<?php

namespace App\DataTables;

use App\Models\SchoolYear;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SchoolYearDataTable extends DataTable
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
                $editBtn = '<a href="#" data-bs-toggle="modal" data-bs-target="#editSchoolYear" ' .
                    'onclick="editSchoolYear(' . $query->id . ', \'' . $query->code . '\', \'' . $query->description . '\', \'' . $query->from . '\', \'' . $query->to . '\', \'' . $query->semester . '\',\'' . $query->status . '\' )">';
                $editBtn .= '<button type="button" class="btn btn-primary waves-effect waves-light">';
                $editBtn .= '<i class="ri-edit-2-fill"></i>';
                $editBtn .= '</button></a>';

                $deletebtn = '<form action="' . route('superadmin.school_year.destroy', $query->id) . '" method="POST">';
                $deletebtn .= csrf_field();
                $deletebtn .= method_field('DELETE');
                $deletebtn .= '<button class="btn btn-danger delete-item mx-1" type="submit"><i class="ri-delete-bin-fill"></i></button>';
                $deletebtn .= '</form>';


                $buttonContainer .= $editBtn . $deletebtn;
                $buttonContainer .= '</div>';
                return $buttonContainer;
            })
            ->addColumn('status', function ($query) {
                if ($query->status == 1) {
                    return '<span class="badge text-bg-success">Active</span>';
                } elseif ($query->status == 0) {
                    return '<span class="badge text-bg-danger">Inactive</span>';
                }
            })
            ->rawColumns(['action', 'status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(SchoolYear $model): QueryBuilder
    {

        // $query = SchoolYear::query();
        // $query->with('semester');
        // return $this->applyScopes($query);
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('schoolyear-table')
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
            Column::make('code'),
            Column::make('description'),
            Column::make('from'),
            Column::make('to'),
            Column::make('semester'),
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
        return 'SchoolYear_' . date('YmdHis');
    }
}
