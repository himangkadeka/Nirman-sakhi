<?php

namespace App\Http\Controllers\Admin\Benefits;

use App\Http\Controllers\Controller;
use App\Models\Benefit;
use App\Models\FormField;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class BenefitFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $benefit_id = decrypt(base64_decode($id));
        $benefit_details = Benefit::findOrFail($benefit_id);;
        $fields =  FormField::where('benefit_id', $benefit_id)->orderBy('order', 'asc')->get();

        $tables = DB::select("SELECT tablename FROM pg_tables WHERE schemaname = 'Masterdata'");
        $workerTables = DB::select("SELECT tablename FROM pg_tables WHERE schemaname = 'Worker'");
        // return $fields;
        return view('admin.benefits.forms.index', compact('benefit_details', 'fields', 'tables', 'workerTables'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $benefitId = $request->input('benefit_id');
        $validator = Validator::make($request->all(), [
            'benefit_id' => 'required|exists:pgsql.Benefit.benefits,id',
            'field_name' => [
                'required',
                'regex:/^[a-z_]+$/', // Stricter regex for snake_case only
                Rule::unique('pgsql.Benefit.form_fields', 'name')->where('benefit_id', $benefitId)
            ],
            'input_type' => 'required',
            'use_masterdata' => 'nullable',
            'masterdata_table' => 'required_if:use_masterdata,true|nullable|string',
            'masterdata_table_key' => 'required_if:use_masterdata,true|nullable|string',
            'masterdata_table_value' => 'required_if:use_masterdata,true|nullable|string',
            'masterdata_table_condition' => 'nullable|string',
            'field_options' => [
                'nullable',
                'string',
                Rule::requiredIf(function () use ($request) {
                    return in_array($request->input_type, ['select', 'checkbox', 'radio']) && !$request->boolean('use_masterdata');
                }),
            ],
            'validation_rules' => 'nullable|json',
            'error_messages' => 'nullable|json',
            'use_prefilled_data' => 'nullable|boolean',
            'prefilled_data_type' => 'required_if:use_prefilled_data,true',
            'prefilled_vault_data_key' => 'required_if:prefilled_data_type,1',
            'prefilled_worker_data_table' => 'required_if:prefilled_data_type,2',
            'prefilled_worker_data_key' => 'required_if:prefilled_data_type,2',
            'use_masterdata_value' => 'nullable|boolean',
            'masterdata_value_table' => 'required_if:use_masterdata_value,true',
            'masterdata_table_prefilled_key' => 'required_if:use_masterdata_value,true',
            'masterdata_table_prefilled_value' => 'required_if:use_masterdata_value,true',
            'use_dependent_field' => 'nullable|boolean',
            'select_dependent_field' => 'required_if:use_dependent_field,true|exists:pgsql.Benefit.form_fields,id',
            'select_dependent_field_details' => 'required_if:use_dependent_field,true',
            'prefilled_table_name' => 'required_if:input_type,prefilled_table|nullable|string',
            'prefilled_table_columns' => 'required_if:input_type,prefilled_table|nullable|string',
            'prefilled_table_headers' => 'required_if:input_type,prefilled_table|nullable|string',
            'prefilled_table_condition_column' => 'required_if:input_type,prefilled_table|nullable|string',

        ], [
            'field_name.unique' => 'This field name already exists for this form.',
            'field_name.regex' => 'The field name must be in snake_case format (e.g., "my_field_name").',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
            Alert::error('Error', $validator->errors()->first());
            return back();
        }
        // return $request->all();

        try {
            $field = new FormField();
            $field->benefit_id = $request->benefit_id;
            $field->name = $request->field_name;
            $field->type = $request->input_type;
            $maxOrder = FormField::where('benefit_id', $request->benefit_id)->max('order') ?? 0;
            $field->order = $maxOrder + 1;
            $field->validation_rules = $request->validation_rules ? $request->validation_rules : null;
            $field->error_messages = $request->error_messages ? $request->error_messages : null;


            if ($request->input_type == 'select' || $request->input_type == 'radio' || $request->input_type == 'checkbox') {
                if ($request->has('use_masterdata') && $request->use_masterdata) {
                    $field->use_masterdata = true;
                    $field->masterdata_table = $request->masterdata_table;
                    $field->masterdata_table_key = $request->masterdata_table_key;
                    $field->masterdata_table_value = $request->masterdata_table_value;
                    $field->masterdata_table_condition = $request->masterdata_table_condition;
                } else {
                    $optionsArray = array_map('trim', explode(',', $request->field_options));
                    $field->options = json_encode(array_combine($optionsArray, $optionsArray));
                }
            }

            if ($request->boolean('use_prefilled_data')) {
                $field->use_prefilled_data = $request->use_prefilled_data;
                $field->prefilled_data_type = $request->prefilled_data_type;
                if ($request->prefilled_data_type == 1) {
                    $field->prefilled_vault_data_key = $request->prefilled_vault_data_key;
                } elseif ($request->prefilled_data_type == 2) {
                    $field->prefilled_worker_data_table = $request->prefilled_worker_data_table;
                    $field->prefilled_worker_data_key = $request->prefilled_worker_data_key;
                    if ($request->boolean('use_masterdata_value')) {
                        $field->use_masterdata_value = $request->use_masterdata_value;
                        if ($request->use_masterdata_value == true) {
                            $field->masterdata_value_table = $request->masterdata_value_table;
                            $field->masterdata_value_table_key = $request->masterdata_table_prefilled_key;
                            $field->masterdata_value_table_value = $request->masterdata_table_prefilled_value;
                        }
                    }
                }
            }

            if ($request->boolean('use_dependent_field')) {
                $field->is_dependent_field = $request->use_dependent_field;
                if ($request->use_dependent_field == true) {
                    $field->dependent_field_id = $request->select_dependent_field;
                    $field->dependent_field_value = $request->select_dependent_field_details;
                }
            }

            if ($request->input_type == 'prefilled_table') {
                $field->prefilled_table_name = $request->prefilled_table_name;
                $field->prefilled_table_columns = $request->prefilled_table_columns;
                $field->prefilled_table_headers = $request->prefilled_table_headers;
                $field->prefilled_table_condition_column = $request->prefilled_table_condition_column;

                // Since this is not a real input, clear other irrelevant values
                $field->validation_rules = json_encode([
                    "required" => false
                ]);

                $field->error_messages = json_encode([
                    "required" => "This field is not required"
                ]);
            }

            $field->save();

            Alert::success('Success', 'Field added successfully');
            return back();
        } catch (Exception $e) {
            Log::error('Benefit Form Store Error: ' . $e->getMessage());
            Alert::error('Error', $e->getMessage());
            return back();
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function updateFieldOrder(Request $request)
    {
        $orderData = $request->input('orderData');

        if (!empty($orderData)) {
            foreach ($orderData as $item) {
                FormField::where('id', $item['id'])->update(['order' => $item['order']]);
            }
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 400);
    }


    public function getKeyValue(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'table_name' => 'required'
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        try {
            $table = $request->table_name;
            $columns = DB::select("
            SELECT column_name
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE table_schema = 'Masterdata'
            AND table_name = ?", [$table]);

            return response()->json([
                'status' => true,
                'results' => array_column($columns, 'column_name')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getWorkerKeyValue(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'table_name' => 'required'
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        try {
            $table = $request->table_name;
            $columns = DB::select("
            SELECT column_name
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE table_schema = 'Worker'
            AND table_name = ?", [$table]);

            return response()->json([
                'status' => true,
                'results' => array_column($columns, 'column_name')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getFieldHaveOptions(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'form_id' => 'required'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'results' => $validator->errors()->first()
            ]);
        }

        try {
            $fields = FormField::select('id', 'name', 'type', 'benefit_id')->whereIn('type', ['select', 'checkbox', 'radio', 'text'])->where('benefit_id', $request->form_id)->get();


            return response()->json([
                'status' => true,
                'results' => $fields
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'results' => $e->getMessage()
            ]);
        }
    }


    public function getFieldOptions(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'field_id' => 'required'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'results' => $validator->errors()->first()
            ]);
        }

        try {
            $fieldDetails = FormField::findOrFail($request->field_id);
            // return $fieldDetails;
            if ($fieldDetails->use_masterdata == true) {
                $options = DB::table('Masterdata.' . $fieldDetails->masterdata_table)
                    ->select($fieldDetails->masterdata_table_key . ' as key', $fieldDetails->masterdata_table_value . ' as value')
                    ->get();
            } else {
                $optionsArray = json_decode($fieldDetails->options, true); // Decode JSON if it's stored as a string
                $options = [];

                foreach ($optionsArray as $index => $item) {
                    $options[] = [
                        'key' => $item,
                        'value' => $item
                    ];
                }
            }
            return response()->json([
                'status' => true,
                'results' => $options
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'results' => $e->getMessage()
            ]);
        }
    }
}
