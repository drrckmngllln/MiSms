<?php

namespace App\DataTables;

use App\Models\instructor;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class instructorDataTable extends DataTable
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

                $editBtn = '<a href="#" data-bs-toggle="modal" data-bs-target="#editModal" onclick="viewModal
                (' . $query->id . ',\'' . $query->full_name . '\')">';
                $editBtn .= '<button type="button" class="btn btn-primary waves-effect waves-light">';
                $editBtn .= '<i class="ri-edit-2-fill"></i>';
                $editBtn .= '</button></a>';

                $deleteBtn = '<form action="' . route('superadmin.instructor.destroy', $query->id) . '" method="POST">';
                $deleteBtn .= csrf_field();
                $deleteBtn .= method_field('DELETE');
                $deleteBtn .= '<button class="btn btn-danger delete-item mx-1" type="submit"><i class="ri-delete-bin-fill"></i></button>';
                $deleteBtn .= '</form>';

                $section = '<a href="#" data-bs-toggle="modal" data-bs-target="#instructorSection" onclick="instructorSection
                (' . $query->id . ',\'' . $query->full_name . '\')">';
                $section .= '<button type="button" class="btn btn-secondary waves-effect waves-light">';
                $section .= 'Section</button></a>';

                $btnContainer .=  $editBtn . $deleteBtn . $section;
                $btnContainer .= '</div>';
                return $btnContainer;
            })
            ->addColumn('department', function ($query) {
                return $query?->department?->code;
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(instructor $model): QueryBuilder
    {
        // return $model->newQuery();
        $query = instructor::query();
        $query->with('department');
        return $this->applyScopes($query);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('instructor-table')
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
            Column::make('full_name'),
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
        return 'instructor_' . date('YmdHis');
    }
}