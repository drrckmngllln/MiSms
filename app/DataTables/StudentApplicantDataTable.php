<?php

namespace App\DataTables;

use App\Models\StudentApplicant;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class StudentApplicantDataTable extends DataTable
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
                $editBtn = '<a href="#" data-bs-toggle="modal" data-bs-target="#editModal" ' .
                    'onclick="editUser(' . $query->id . ', \'' . $query->semester . '\', \'' . $query->id_number . '\' ,\'' . $query->last_name . '\',\'' . $query->first_name . '\', \'' . $query->middle_name . '\', \'' . $query->suffix . '\',  \'' . $query->gender . '\',\'' . $query->date_of_birth . '\', \'' . $query->place_of_birth . '\', \'' . $query->nationality . '\',\'' . $query->religion . '\' ,\'' . $query->status . '\' )">';

                $editBtn .= '<button type="button" class="btn btn-primary waves-effect waves-light">';
                $editBtn .= '<i class="ri-edit-2-fill"></i>';
                $editBtn .= '</button></a>';
                try {
                    $viewBtn = '<a href="#" class="view-btn" data-bs-toggle="modal" data-bs-target="#viewModal" ' .
                        'onclick="viewUser(' . $query->id . ', \'' . $query->id_number . '\', ' .
                        '\'' . $query->gender . '\', \'' . $query->date_of_birth . '\', ' .
                        '\'' . $query->place_of_birth . '\', \'' . $query->nationality . '\', ' .
                        '\'' . $query->religion . '\', \'' . $query->last_name . '\', ' .
                        '\'' . $query->first_name . '\', \'' . $query->middle_name . '\', ' .
                        '\'' . $query->suffix . '\', \'' . $query->status . '\',\'' . $query->enrolled_student?->section->section_code . '\', \'' . $query->enrolled_student?->curriculum_id . '\'  )">';
                    $viewBtn .= '<button type="button" class="btn btn-success waves-effect waves-light mx-1">';
                    $viewBtn .= '<i class="ri-eye-fill"></i>';
                    $viewBtn .= '</button></a>';
                } catch (\Exception $e) {
                    dd($e);
                }
                //if statement if approved the for enrollment button will appear
                if ($query->status == 1) {
                    $enrllBtn = '<a href="#" data-bs-toggle="modal" data-bs-target="#viewForEnrollement" ' .
                        'onclick="viewEnrollment(' . $query->id  . ')">';
                    $enrllBtn .= '<button type="button" class="btn btn-success waves-effect waves-light mx-1">';
                    $enrllBtn .= 'For Enrollment';
                    $enrllBtn .= '</button></a>';
                    $buttonContainer .= $enrllBtn;
                }

                if ($query->enrolled_student?->status == 1) {
                    $assestBtn = '<a href="#" data-bs-toggle="modal" data-bs-target="#viewForAssesment" ' .
                        'onclick="viewAssesment(' . $query->id  . ',\'' . $query->last_name . '\',\'' . $query->first_name . '\',\'' . $query->middle_name . '\',\'' . $query->enrolled_student?->id_number . '\', \'' . $query->enrolled_student?->course->code . '\', \'' . $query->enrolled_student?->year_level . '\', \'' . $query->enrolled_student?->section->section_code . '\', \'' . $query->enrolled_student?->semester . '\')">';
                    $assestBtn .= '<button type="button" class="btn btn-secondary waves-effect waves-light mx-1">';
                    $assestBtn .= 'Assesment';
                    $assestBtn .= '</button></a>';
                    $buttonContainer .= $assestBtn;
                }

                $buttonContainer .= $editBtn . $viewBtn;
                $buttonContainer .= '</div>';
                return $buttonContainer;
            })

            ->addColumn('image', function ($query) {
                if (empty($query->image)) {
                    return "<img width='90px' height='90px' src='" . asset('backend/assets/images/person-7243410_1280.png') . "'></img>";
                } else {
                    return "<img width='90px' height='90px' src='" . asset($query->image) . "'></img>";
                }
            })
            ->addColumn('full_name', function ($query) {
                // Combine the name parts into a single string
                return $query->last_name . ', ' . $query->first_name . ' ' . $query->middle_name . ' ,' . $query->suffix;
            })
            ->addColumn('status', function ($query) {
                if ($query->status == 1) {
                    $statusHtml = '<div class="font-size-13">';
                    $statusHtml .= '<span class="badge bg-success align-middle me-2">FOR ENROLLMEMT</span>';
                    $statusHtml .= '</div>';
                } else {
                    $statusHtml = '<div class="font-size-13">';
                    $statusHtml .= '<span class="badge bg-warning align-middle me-2">PENDING</span>';
                    $statusHtml .= '</div>';
                }


                // Create the toggle switch HTML
                // Combine the status badge and toggle switch
                $html = $statusHtml;
                return $html;
            })
            //eto yung relationship sa course para makita siya sa yajra table comment outna muna natin
            // ->addColumn('course', function ($query) {
            //     return $query->course->description;
            // })

            ->rawColumns(['image', 'action', 'status', 'full_name'])
            ->setRowId('id');
    }
    /**
     * Get the query source of dataTable.
     */
    public function query(StudentApplicant $model): QueryBuilder
    {
        // $query = StudentApplicant::query();
        // $query->with('course');
        // return $this->applyScopes($query);

        return $model->newQuery();
    }
    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('studentapplicant-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            // ->dom('id')
            // ->orderBy(1)
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
            Column::make('id_number')->width(150, 'dt-responsive'),
            Column::make('full_name')->width(100, 'dt-responsive'),
            Column::make('status')->width(100, 'dt-responsive'),
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
        return 'StudentApplicant_' . date('YmdHis');
    }
}
