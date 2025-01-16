<?php

namespace App\DataTables;

use App\Models\CreateAccount;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CreateAccountDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {

        return (new EloquentDataTable($query))
            ->addColumn('Check Box', function ($query) {
                $check = '<input type="checkbox" class="form-check-input" name="check[]" id="check" value="' . $query->id . ',' . $query->id_number . ',' . $query->year_level . '">';
                return $check;
            })

            ->addColumn('action', function ($query) {

                $btncontainer = '<div class="d-flex justify-content-center">';

                $studentIntersession = '<a href="#" data-bs-toggle="modal" data-bs-target="#interSession" onclick="Intersession(' . $query->id . ',\'' . $query->id_number . '\')">';
                $studentIntersession .= '<button type="button" class="btn btn-primary waves-effect waves-light mx-1">Promote</button></a>';

                $deleteBtn = '<form action="' . route('superadmin.create_account.destroy', $query->id) . '" method="POST">';
                $deleteBtn .= csrf_field();
                $deleteBtn .= method_field('DELETE');
                $deleteBtn .= '<button class="btn btn-danger delete-item mx-1" type="submit"><i class="ri-delete-bin-fill"></i></button>';
                $deleteBtn .= '</form>';

                $editbtn = '<a href="#" data-bs-toggle="modal" data-bs-target="#editCreateAccount" onclick="createaccount
                    (' . $query->id . ', \'' . $query->id_number . '\',\'' . $query->sy_enrolled . '\', \'' . $query->school_year . '\', 
                    \'' . $query->last_name . '\', \'' . $query->first_name . '\', \'' . $query->middle_name . '\',
                     \'' . $query->gender . '\',\'' . $query->civil_status . '\', \'' . $query->date_of_birth . '\', 
                     \'' . $query->place_of_birth . '\', \'' . $query->nationality . '\', \'' . $query->religion . '\',
                     \'' . $query->course_id . '\',\'' . $query->admission_date . '\',\'' . $query->campus_id . '\',
                     \'' . $query->discount_id . '\',\'' . $query->control_number . '\',\'' . $query->email . '\',
                     \'' . $query->home_address . '\',\'' . $query->type_of_students . '\', \'' . $query->year_level . '\', 
                     \'' . $query->elementary . '\',\'' . $query->year_graduated_elem . '\',\'' . $query->junior_high_school . '\',
                     \'' . $query->year_graduated_elem_jhs . '\',\'' . $query->senior_high_school . '\',\'' . $query->year_graduated_elem_shs . '\',
                     \'' . $query->mothers_fullname . '\',\'' . $query->occupation_mother . '\',\'' . $query->contact_number_mother . '\',
                     \'' . $query->fathers_fullname . '\',\'' . $query->occupation_father . '\',\'' . $query->contact_number_father . '\',
                     \'' . $query->island . '\', \'' . $query->municipality . '\', \'' . $query->barangay . '\',
                      \'' . $query->municipality_code . '\', \'' . $query->barangay_code . '\',\'' . $query->extention . '\', 
                      \'' . $query->streetname . '\', \'' . $query->houseno . '\', \'' . $query->regioncode . '\', \'' . $query->regionname . '\')">';
                $editbtn .= '<button type="button" class="btn btn-primary waves-effect waves-light mx-1"><i class="ri-edit-2-fill"></i></button></a>';

                $approveStudent = '<a href="#" data-bs-toggle="modal" data-bs-target="#selectCurriculum" onclick="approveStudent(' . $query->id . ', \'' . $query->first_name . '\', \'' . $query->middle_name . '\', \'' . $query->last_name . '\', \'' . $query?->course?->code . '\', \'' . $query?->course?->id . '\' )">';
                $approveStudent .= '<button type="button" class="btn btn-primary waves-effect waves-light">Approve</button></a>';

                $enrllBtn = '<a href="#" data-bs-toggle="modal" data-bs-target="#enrollStudent" ' .
                    'onclick="enrollStudents(' . $query->id  . ', \'' . $query->id_number . '\',\'' . $query?->curriculum?->id . '\',
                        \'' . $query?->course?->id . '\',\'' . $query?->curriculum?->campus_id . '\',\'' . $query->first_name . '\',
                        \'' . $query->middle_name . '\',\'' . $query->last_name . '\')">';
                $enrllBtn .= '<button type="button" class="btn btn-success waves-effect waves-light">Enroll Student</button></a>';


                $accBtn = '<a href="#" data-bs-toggle="modal" data-bs-target="#accountingModal" ' .
                    'onclick="studentAss(' . $query->id . ', \'' . $query->id_number . '\',\'' . $query->first_name . '\', \'' . $query->middle_name . '\',  \'' . $query->last_name . '\',\'' . $query->course_id . '\',\'' . $query->campus_id . '\', \'' . $query?->studentSubjectss?->year_level . '\',
                    \'' . $query?->studentSubjectss?->semester . '\',\'' . $query->school_year . '\',\'' . $query->studentSubjectss?->department_id . '\')">';
                $accBtn .= '<button type="button" class="btn btn-success waves-effect waves-light mx-1">  Accounting</button></a>';

                $viewSubBtn = '<a href="#" data-bs-toggle="modal" data-bs-target="#viewSubModal" ' .
                    'onclick="studentSub(' . $query->id . ', \'' . $query->id_number . '\', 
                    \'' . $query->first_name . '\',\'' . $query->middle_name . '\', \'' . $query->last_name . '\',
                    \'' . $query?->student_subject?->year_level . '\',\'' . $query?->student_subject?->school_year . '\',\'' . $query?->student_subject?->course_id . '\' ,
                     \'' . $query->campus_id . '\', \'' . $query?->student_subject?->curriculum_id . '\',\'' . $query?->student_subject?->semester . '\',
                     \'' . $query?->student_subject?->school_year . '\', \'' . $query?->student_subject?->department_id . '\',\'' . $query?->student_subject?->section_id . '\'
                     )">';
                $viewSubBtn .= '<button type="button" class="btn btn-secondary waves-effect waves-light mx--10"><i class="ri-eye-fill"></i></button></a>';

                $printBtn = '<a href="#" data-bs-toggle="modal" data-bs-target="" ' .
                    'onclick="printStudentAssessment(' . $query->id . ', \'' . $query->id_number . '\', \'' . $query->first_name . '\',\'' . $query->middle_name . '\', \'' . $query->last_name . '\', \'' . $query->school_year . '\', \'' . $query->course?->code . '\')">';
                $printBtn .= '<button type="button" class="btn btn-secondary waves-effect waves-light mx-1"><i class="ri-printer-line"></i></button></a>';

                $promoteStudentBtn = '<a href="#" data-bs-toggle="modal" data-bs-target="" ' .
                    'onclick="promoteStudents(' . $query->id . ')">';
                $promoteStudentBtn .= '<button type="button" class="btn btn-secondary waves-effect waves-light mx-1">Promote</button></a>';

                if (Auth::check()) {
                    $user = Auth::user();

                    switch ($query->status) {
                        case 'PENDING':
                            if (!$user->hasAnyRole(['Finance Cashier', 'Super Admin for Finance', 'Super Admin for Accounting'])) {
                                $btncontainer .= $approveStudent;
                                $btncontainer .= $editbtn;
                                $btncontainer .= $deleteBtn;
                            }
                            break;

                        case 'FOR ENROLLMENT':
                            if ($user->hasAnyRole(['Registrar', 'Super_Administrator', 'Evaluator'])) {
                                $btncontainer .= $enrllBtn;
                                $btncontainer .= $editbtn;
                                $btncontainer .= $deleteBtn;
                            } else if (!$user->hasAnyRole(['Finance Cashier', 'Super Admin for Finance', 'Super Admin for Accounting'])) {
                                $btncontainer .= $enrllBtn;
                                $btncontainer .= $editbtn;
                            }
                            break;

                        case 'ACCOUNTING':
                            if ($user->hasAnyRole(['Finance Cashier', 'Super Admin for Finance', 'Super Admin for Accounting'])) {
                                $btncontainer .= $accBtn;
                            } else if ($user->hasRole('Super_Administrator')) {
                                $btncontainer .= $editbtn;
                                $btncontainer .= $accBtn;
                                $btncontainer .= $viewSubBtn;
                            } else if ($user->hasAnyRole(['Registrar', 'High School Department Super Administrator'])) {
                                $btncontainer .= $viewSubBtn;
                                $btncontainer .= $editbtn;
                            }
                            break;

                        case 'PROCEED TO CASHIER':
                            $btncontainer .= $printBtn;
                            if ($user->hasRole('Registrar')) {
                                $btncontainer .= $viewSubBtn;
                            }
                            break;

                        case 'OFFICIALLY ENROLLED':
                            if ($user->hasRole('Super Admin for Finance') || $user->hasRole('Super Admin for Accounting')) {
                                $btncontainer .= $printBtn;
                            } else if ($user->hasRole('Super_Administrator')) {
                                $btncontainer .= $deleteBtn;
                                $btncontainer .= $viewSubBtn;
                                $btncontainer .= $studentIntersession;
                                $btncontainer .= $printBtn;
                                $btncontainer .= $editbtn;
                            } else if ($user->hasAnyRole(['Registrar', 'High School Department Super Administrator'])) {
                                $btncontainer .= $studentIntersession;
                                $btncontainer .= $viewSubBtn;
                                $btncontainer .= $deleteBtn;
                                $btncontainer .= $printBtn;
                            } else if ($user->hasRole('Evaluator')) {
                                $btncontainer .= $viewSubBtn;
                                $btncontainer .= $studentIntersession;
                            }
                            break;

                        case 'CANCEL ACCOUNT':
                            $btncontainer .= $studentIntersession;
                            break;
                    }
                }


                $btncontainer .= '</div>';
                return $btncontainer;
            })
            // ->addColumn('fullname', function ($query) {
            //     return $query->first_name . ' ' . $query->middle_name . ' ' . $query->last_name;
            // })
            ->addColumn('status', function ($query) {
                if ($query->status == 'PENDING') {
                    $statusHtml = '<div class="font-size-13"><span class="badge bg-warning align-middle me-2">PENDING</span></div>';
                } elseif ($query->status == 'FOR ENROLLMENT') {
                    $statusHtml = '<div class="font-size-13"><span class="badge bg-success align-middle me-2">FOR ENROLLMENT</span></div>';
                } elseif ($query->status == 'ACCOUNTING') {
                    $statusHtml = '<div class="font-size-13"><span class="badge bg-success align-middle me-2">PROCEED TO ACCOUNTING</span></div>';
                } elseif ($query->status == 'PROCEED TO CASHIER') {
                    $statusHtml = '<div class="font-size-13"><span class="badge bg-success align-middle me-2">PROCEED TO CASHIER</span></div>';
                } elseif ($query->status == 'OFFICIALLY ENROLLED') {
                    $statusHtml = '<div class="font-size-13"><span class="badge bg-success align-middle me-2">OFFICIALLY ENROLLED</span></div>';
                } elseif ($query->status == 'CANCEL ACCOUNT') {
                    $statusHtml = '<div class="font-size-13"><span class="badge bg-danger align-middle me-2">CANCEL ACCOUNT</span></div>';
                }

                // Create the toggle switch HTML
                // Combine the status badge and toggle switch
                return $statusHtml;
            })
            ->addColumn('course', function ($query) {
                return $query->course?->code;
            })
            ->filterColumn('course', function ($query, $keyword) {
                $query->whereHas('course', function ($q) use ($keyword) {
                    $q->where('code', 'like', "%{$keyword}%");
                });
            })

            ->rawColumns(['action', 'fullname', 'status', '', 'Check Box', 'school_year'])
            ->setRowId('id', 'course');
    }


    /**
     * Get the query source of dataTable.
     */
    public function query(CreateAccount $model): QueryBuilder
    {


        $query = CreateAccount::query();
        $query->with('course')
            ->with('schoolyear');
        return $this->applyScopes($query);

        // return $model->newQuery();
    }
    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('createaccount-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('Check Box')->width(150, 'dt-responsive'),
            Column::make('admission_date')->width(150, 'dt-responsive'),
            Column::make('last_name')->width(150, 'dt-responsive'),
            Column::make('first_name')->width(150, 'dt-responsive'),
            Column::make('id_number')->width(150, 'dt-responsive'),
            Column::make('course')->width(150, 'dt-responsive'),
            Column::make('status')->width(150, 'dt-responsive'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(150)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'CreateAccount_' . date('YmdHis');
    }
}
