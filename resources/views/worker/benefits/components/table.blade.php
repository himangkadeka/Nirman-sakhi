@php
                                        // Initialize variables to avoid errors
                                        $tableData = collect();
                                        $headers = [];
                                        $columns = [];

                                        // 1. Safety Check: Ensure all required configuration fields are set
                                        if (
                                            !empty($field->prefilled_table_name) &&
                                            !empty($field->prefilled_table_columns) &&
                                            !empty($field->prefilled_table_headers) &&
                                            !empty($field->prefilled_table_condition_column)
                                        ) {
                                            // 2. Parse the comma-separated strings into arrays
                                            $columns = explode(',', $field->prefilled_table_columns);
                                            $headers = explode(',', $field->prefilled_table_headers);

                                            // 3. Query the database only if headers and columns count match
                                            if (count($columns) === count($headers)) {
                                                $tableData = DB::table("Worker.{$field->prefilled_table_name}")
                                                    ->select($columns)
                                                    ->where($field->prefilled_table_condition_column, $wmf->worker_id)
                                                    ->get();
                                            }
                                        }
                                    @endphp

                                    {{-- 4. Render the HTML Table --}}
                                    <div class="table-responsive" style="margin-top: 5px;">
                                        <table class="table table-bordered table-striped table-sm" style="font-size: 14px;">
                                            <thead class="thead-light">
                                                <tr>
                                                    @foreach ($headers as $header)
                                                        <th>{{ $header }}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($tableData->isNotEmpty())
                                                    @foreach ($tableData as $row)
                                                        <tr>
                                                            @foreach ($columns as $column)
                                                                {{-- Access the row property dynamically using the column name --}}
                                                                <td>{{ $row->{trim($column)} ?? 'N/A' }}</td>
                                                            @endforeach
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    {{-- Show a message if no data is found --}}
                                                    <tr>
                                                        <td colspan="{{ count($headers) }}" class="text-center">No data
                                                            available.</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
