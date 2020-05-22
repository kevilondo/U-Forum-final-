<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Course;

class CourseController extends Controller
{
    //fetch the courses after the student has selected the university

    public function fetch(Request $request)
    {
        $select = $request->get('select');
        $value = $request->get('value');
        $dependent = $request->get('dependent');
        $data = Course::where($select, $value)->orderBy('name', 'asc')->get();
        $output = '<option value="">Select your course </option>';

        foreach ($data as $row)
        {
            $output .= '<option value="'.$row->name. '">'. $row->name. '</option>';
        }

        echo $output;
    }

}
