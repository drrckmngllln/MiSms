<?php

namespace App\DataTables;

use App\Models\Campus;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CampusDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function($query){
                $btnContainer = '<div class="d-flex justify-content-center">';
               
                $editBtn = '<a href="#" data-bs-toggle="modal" data-bs-target="#editModal" onclick="editUser
                ('.$query->id.',\' '.$query->code.' \', \''.$query->description.'\', \''.$query->address.'\', \''.$query->is_active.'\')">';
                $editBtn .= '<button type="button" class="btn btn-primary waves-effect waves-light">';
                $editBtn .= '<i class="ri-edit-2-fill"></i>';
                $editBtn .= '</button></a>';
               
               
                
                $deleteBtn = '<form action="' . route('superadmin.campuses.destroy', $query->id) . '" method="POST">';
                $deleteBtn .= csrf_field();
                $deleteBtn .= method_field('DELETE');
                $deleteBtn .= '<button class="btn btn-danger delete-item mx-1" type="submit"><i class="ri-delete-bin-fill"></i></button>';
                $deleteBtn .= '</form>';

                $btnContainer .= $editBtn.$deleteBtn;
                $btnContainer .= '</div>';
                return $btnContainer;
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Campus $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('campus-table')
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
            Column::make('address'),
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
        return 'Campus_' . date('YmdHis');
    }
}
