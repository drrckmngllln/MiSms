<?php

namespace App\DataTables;

use App\Models\StudentApplicant;
use App\Models\StudentsAdmitted;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class StudentsAdmittedDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($query) {
                $buttonContainer = '<div class="d-flex justify-content-center">';

                $editBtn = '<a href="#" data-bs-toggle="modal" data-bs-target="#editModal" onclick="editStudents(' . $query->id . ', \'' . $query->first_name . '\', \'' . $query->middle_name . '\', \'' . $query->last_name . '\', \'' . $query->prefix . '\', \'' . $query->email . '\', \'' . $query->date_of_birth . '\', \'' . $query->place_of_birth . '\',\'' . $query->religion . '\', \'' . $query->nationality . '\', \'' . $query->gender . '\',\'' . $query->civil_status . '\',\'' . $query->dialect . '\',\'' . $query->contact_number . '\',\'' . $query->complete_address . '\',\'' . $query->fathers_fullname . '\',\'' . $query->fathers_occupation . '\',\'' . $query->mothers_fullname . '\', \'' . $query->mothers_occupation . '\',\'' . $query->parents_address . '\',\'' . $query->parents_contact_number . '\',\'' . $query->guardian_fullname . '\', \'' . $query->guardian_address . '\',\'' . $query->employer_details . '\',\'' . $query->primary_school . '\',\'' . $query->secondary_school . '\',\'' . $query->junior_highschool . '\',\'' . $query->senior_highschool . '\',\'' . $query->last_school_attended . '\',\'' . $query->lastschool_name . '\',\'' . $query->lastschool_address . '\',\'' . $query->course_id . '\',\'' . $query->currirulum_id . '\',\'' . $query->student_type . '\',\'' . $query->year_level . '\',\'' . $query->fullname . '\',\'' . $query->form_138 . '\',\'' . $query->transcript_of_record . '\',\'' . $query->honorable_dismissal . '\', \'' . $query->birth_certificate . '\', \'' . $query->ncae_copt . '\', \'' . $query->good_moral . '\',  \'' . $query->true_copy_of_grades . '\', \'' . $query->police_clearance . '\')">';
                $editBtn .= '<button type="button" class="btn btn-primary waves-effect waves-light">';
                $editBtn .= '<i class="ri-edit-2-fill"></i>';
                $editBtn .= '</button></a>';


                $viewBtn = '<a href="#" class="view-btn" data-bs-toggle="modal" data-bs-target="#viewModal" onclick="viewUser(' . $query->id . ', \'' . $query->first_name . '\', \'' . $query->middle_name . '\',\'' . $query->last_name . '\', \'' . $query->prefix . '\', \'' . $query->email . '\', \'' . $query->date_of_birth . '\', \'' . $query->place_of_birth . '\',\'' . $query->religion . '\', \'' . $query->nationality . '\', \'' . $query->gender . '\',\'' . $query->civil_status . '\',\'' . $query->dialect . '\',\'' . $query->contact_number . '\',\'' . $query->complete_address . '\',\'' . $query->fathers_fullname . '\',\'' . $query->fathers_occupation . '\',\'' . $query->mothers_fullname . '\', \'' . $query->mothers_occupation . '\',\'' . $query->parents_address . '\',\'' . $query->parents_contact_number . '\',\'' . $query->guardian_fullname . '\', \'' . $query->guardian_address . '\',\'' . $query->employer_details . '\',\'' . $query->primary_school . '\',\'' . $query->secondary_school . '\',\'' . $query->junior_highschool . '\',\'' . $query->senior_highschool . '\',\'' . $query->last_school_attended . '\',\'' . $query->lastschool_name . '\',\'' . $query->lastschool_address . '\',\'' . $query->course_id . '\',\'' . $query->currirulum_id . '\',\'' . $query->student_type . '\',\'' . $query->year_level . '\',\'' . $query->fullname . '\',\'' . $query->form_138 . '\',\'' . $query->image . '\', \'' . $query->transcript_of_record . '\', \'' . $query->honorable_dismissal . '\', \'' . $query->birth_certificate . '\', \'' . $query->ncae_copt . '\',  \'' . $query->good_moral . '\', \'' . $query->true_copy_of_grades . '\', \'' . $query->police_clearance . '\', \'' . $query->enrollmentStatus . '\', \'' . $query->status . '\', \'' . $query->student_id . '\', \'' . $query->section_id . '\')">';
                $viewBtn .= '<button type="button" class="btn btn-success waves-effect waves-light">';
                $viewBtn .= '<i class="ri-eye-fill"></i>';
                $viewBtn .= '</button></a>';

                $deleteBtn = '<form action="' . route('superadmin.admit_students.destroy', $query->id) . '" method="POST">';
                $deleteBtn .= csrf_field();
                $deleteBtn .= method_field('DELETE');
                $deleteBtn .= '<button class="btn btn-danger delete-item mx-1" type="submit"><i class="ri-delete-bin-fill"></i></button>';
                $deleteBtn .= '</form>';

                $buttonContainer .= $editBtn . $deleteBtn . $viewBtn;
                $buttonContainer .= '</div>';

                return $buttonContainer;
            })
            ->addColumn('add subject', function ($query) {
                $buttonContainer = '<div class="d-flex justify-content-center">';

                // $addsubBtn = '<a href="" data-bs-toggle="modal" data-bs-target="#">';
                // $addsubBtn .= '<button type="button" class="btn btn-primary waves-effect waves-light">';
                // $addsubBtn .= '<i class="ri-add-fill"></i>';
                // $addsubBtn .= '</button></a>';


                // $buttonContainer .= $addsubBtn;
                // $buttonContainer .= '</div>';

                return $buttonContainer;
            })
            ->addColumn('image', function ($query) {
                if (empty($query->image)) {

                    return "<img width='90px' height='90px' src='" . asset('backend/assets/images/person-7243410_1280.png') . "'></img>";
                } else {

                    return "<img width='90px' height='90px' src='" . asset($query->image) . "'></img>";
                }
            })

            ->addColumn('status', function ($query) {
                if ($query->status) {
                    $statusHtml = '<div class="font-size-13">';
                    $statusHtml .= '<span class="badge bg-success align-middle me-2">Active</span>';
                    $statusHtml .= '</div>';
                } else {
                    $statusHtml = '<div class="font-size-13">';
                    $statusHtml .= '<span class="badge bg-warning align-middle me-2">Inactive</span>';
                    $statusHtml .= '</div>';
                }

                // Create the toggle switch HTML


                // Combine the status badge and toggle switch
                $html = $statusHtml;

                return $html;
            })
            //para mag pakita yung course sa yajra
            ->addColumn('course', function ($query) {
                return $query->course->description;
            })

            ->rawColumns(['image', 'action', 'status', 'add subject'])
            ->setRowId('id');
    }
    /**
     * Get the query source of dataTable.
     */
    public function query(StudentsAdmitted $model): QueryBuilder
    {


        // $query = StudentApplicant::query();
        // $query->where('status', 1);

        // return $this->applyScopes($query);
        $query = StudentsAdmitted::query();
        $query->with('course');


        return $this->applyScopes($query);



        // return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('studentsadmitted-table')
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
            Column::make('image')->width(150, 'dt-responsive'),
            Column::make('fullname')->width(100, 'dt-responsive'),
            Column::make('course')->width(200, 'dt-responsive'),
            Column::make('year_level')->width(100, 'dt-responsive'),
            Column::make('enrollmentStatus')->width(100, 'dt-responsive'),
            Column::computed('add subject')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'StudentsAdmitted_' . date('YmdHis');
    }
}
