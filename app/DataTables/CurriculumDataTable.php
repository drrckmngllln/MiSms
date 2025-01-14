<?php

namespace App\DataTables;

use App\Models\Curriculum;
use App\Models\CurriculumSubject;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CurriculumDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @param QueryBuilder $queryCurriculumSubject
     */


    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))

            ->addColumn('action', function ($query) {
                $btncontainer = '<div class="d-flex justify-content-center">';

                $showSubjects = '<a class="btn btn-success mx-1" href="' . route('superadmin.curriculum_subjects.index', $query->id) . '">';
                $showSubjects .= '<i class="fa-solid fa-ellipsis">Subjects</i>';
                $showSubjects .= '</a>';

                $editbtn = '<a href="#" data-bs-toggle="modal" data-bs-target="#editModal" onclick="editCurriculum
                (' . $query->id . ', \'' . $query->code . '\',\'' . $query->description . '\', \'' . $query->campus_id . '\', \'' . $query->course_id . '\',
                \'' . $query->effective . '\', \'' . $query->expires . '\', \'' . $query->status . '\')">';
                $editbtn .= '<button type="button" class="btn btn-primary waves-effect waves-light">';
                $editbtn .= '<i class="ri-edit-2-fill"></i>';
                $editbtn .= '</button></a>';

                $deletebtn = '<form action="' . route('superadmin.curriculum.destroy', $query->id) . '" method="POST">';
                $deletebtn .= csrf_field();
                $deletebtn .= method_field('DELETE');
                $deletebtn .= '<button class="btn btn-danger delete-item mx-1" type="submit"><i class="ri-delete-bin-fill"></i></button>';
                $deletebtn .= '</form>';

                $btncontainer .= $showSubjects . $editbtn . $deletebtn;
                $btncontainer .= '</div>';
                return $btncontainer;
            })
            ->addColumn('status', function ($query) {
                if ($query->status == 1) {
                    return $statusbtn = '<span class="badge text-bg-success">Active</span>
                    ';
                } else if ($query->status == 0) {
                    return $statusbtn = '<span class="badge text-bg-danger">Inactive</span>
                    ';
                }
            })

            ->rawColumns(['action', 'status', 'CheckBox'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Curriculum $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('curriculum-table')
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
            // Column::make('id'),
            Column::make('code'),
            Column::make('description'),
            Column::make('campus_id'),
            Column::make('course_id'),
            Column::make('effective'),
            Column::make('expires'),
            Column::make('status'),
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
        return 'Curriculum_' . date('YmdHis');
    }
}
