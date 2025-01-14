<?php

namespace App\DataTables;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SubjectDataTable extends DataTable
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
                $btnContainer = '<div class="d-flex justify-content-center">';

                $editBtn = '<a href="#" data-bs-toggle="modal" data-bs-target="#editModal" onclick="editUser
                (' . $query->id . ',\' ' . $query->semester_id . ' \', \'' . $query->code . '\', \'' . $query->descriptive_tittle . '\', \'' . $query->total_units . '\', 
                \'' . $query->lecture_units . '\', \'' . $query->lab_units . '\', \'' . $query->pre_requisite . '\', \'' . $query->total_hrs_per_week . '\', 
                \'' . $query->is_active . '\')">';
                $editBtn .= '<button type="button" class="btn btn-primary waves-effect waves-light">';
                $editBtn .= '<i class="ri-edit-2-fill"></i>';
                $editBtn .= '</button></a>';



                $deleteBtn = '<form action="' . route('superadmin.subjects.destroy', $query->id) . '" method="POST">';
                $deleteBtn .= csrf_field();
                $deleteBtn .= method_field('DELETE');
                $deleteBtn .= '<button class="btn btn-danger delete-item mx-1" type="submit"><i class="ri-delete-bin-fill"></i></button>';
                $deleteBtn .= '</form>';

                $btnContainer .= $editBtn . $deleteBtn;
                $btnContainer .= '</div>';
                return $btnContainer;
            })
            ->rawColumns(['action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Subject $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('subject-table')
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
            Column::make('semester_id'),
            Column::make('code'),
            Column::make('descriptive_tittle'),
            Column::make('total_units'),
            Column::make('lecture_units'),
            Column::make('lab_units'),
            Column::make('pre_requisite'),
            Column::make('total_hrs_per_week'),
            Column::make('is_active'),
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
        return 'Subject_' . date('YmdHis');
    }
}