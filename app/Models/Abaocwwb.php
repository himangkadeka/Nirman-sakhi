<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Exception;

class Abaocwwb extends Model
{
    use HasFactory;




    /*UPDATED DATAS ARE STORED IN ALPHABETICAL ORDER*/
    public static function getAllData($tablename, $orderBy = [])
    {
        $query = DB::table($tablename);

        foreach ($orderBy as $field => $sortOrder) {
            $query->orderBy($field, $sortOrder);
        }

        $data = $query->get();
        return $data;
    }




    public static function getAllGroupByData($tablename,$groupby,$select,$orderby)
    {
        $data = DB::table($tablename)->groupBy($groupby)->orderBy($orderby)->get($select);
        return $data;
    }
    public static function getUserInfo($tablename,$username)
    {
        $data = DB::table($tablename)->where('username','=',$username)->get();
        return $data;

    }
    public static function getUserInfobyId($tablename,$userid)
    {
        $data = DB::table($tablename)->where('id','=',$userid)->get();
        return $data;
    }
    public static function insertData($tablename,$insertarr)
    {
        try
        {
            DB::table($tablename)->insert($insertarr);
            return 1;

        }catch (Exception $e)
        {
            return 0;
        }
    }
    public static function whereclause($tablename,$wherearr)
    {
        $data = DB::table($tablename)->where($wherearr)->get();
        return $data;

    }
    public static function innerjointwotables($table1,$table2,$cond,$equal,$secondcond,$selectfield)
    {
        $data = DB::table($table1)
            ->join($table2,$cond,$equal,$secondcond)
            ->select($selectfield[0])->get();
        return $data;
    }
    public static function innerjointhreetables($table,$table1,$table2,$cond,$cond1,$cond2,$cond3,$equal,$selectfield,$order,$wherearr)
    {
        if(isset($wherearr))
        {
            $data = DB::table($table)
                ->join($table1,$cond1,$equal,$cond)
                ->join($table2,$cond3,$equal,$cond2)
                ->select($selectfield[0])->orderBy($order)->where($wherearr)->get();
        }
        else
        {
            $data = DB::table($table)
                ->join($table1,$cond1,$equal,$cond)
                ->join($table2,$cond3,$equal,$cond2)
                ->select($selectfield[0])->orderBy($order)->get();
        }
        return $data;

    }
    public static function innerjoinfourtables($table,$table1,$table2,$table3,$cond,$cond1,$cond2,$cond3,$cond4,$cond5,$equal,$selectfield,$order,$wherearr)
    {
        if(isset($wherearr))
        {
            $data = DB::table($table)
                ->join($table1,$cond1,$equal,$cond)
                ->join($table2,$cond3,$equal,$cond2)
                ->join($table3,$cond5,$equal,$cond4)
                ->select($selectfield[0])->orderBy($order)->where($wherearr)->get();
        }
        else
        {
            $data = DB::table($table)
                ->join($table1,$cond1,$equal,$cond)
                ->join($table2,$cond3,$equal,$cond2)
                ->join($table3,$cond5,$equal,$cond4)
                ->select($selectfield[0])->orderBy($order)->get();
        }
        return $data;

    }


    public static function updateData($tablename, $updatearr, $wherearr)
    {
        try {
            DB::table($tablename)->where($wherearr)->update($updatearr);
            return 1;
        } catch (QueryException $e) {
            // Log the error or return the error message
            return 0;
        }
    }

    public function setEmailAttribute($value)
    {
        \Log::info("Original Email: $value");
        $this->attributes['email'] = str_replace(['@', '.'], ['[at]', '[dot]'], $value);
        \Log::info("Transformed Email: {$this->attributes['email']}");
    }

    public function getEmailAttribute($value)
    {
        \Log::info("Stored Email: $value");
        return str_replace(['[at]', '[dot]'], ['@', '.'], $value);
    }








    public static function deleteData($tablename, $wherearr)
    {
        try {
            DB::table($tablename)->where($wherearr)->delete();
            return 1;
        } catch (\Exception $e) {
            return 0;
        }
    }

    public static function deactivateData($tablename, $wherearr)
    {
        try {
            // Assuming 'status' is the column you added to represent the state's status
            DB::table($tablename)->where($wherearr)->update(['status' => 'inactive']);
            return 1;
        } catch (\Exception $e) {
            return 0;
        }
    }

    public static function activateData($tablename, $wherearr)
    {
        try {
            DB::table($tablename)->where($wherearr)->update(['status' => 'activate']);
            return 1;
        } catch (\Exception $e) {
            return 0;
        }
    }








}
