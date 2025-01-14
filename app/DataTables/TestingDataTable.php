<?php

namespace App\DataTables;

use App\Models\Testing;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class TestingDataTable extends DataTable
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
                $editBtn = '<a href="#" data-bs-toggle="modal" data-bs-target="#editModal">';
                $editBtn .= '<button type="button" class="btn btn-primary waves-effect waves-light">';
                $editBtn .= '<i class="ri-edit-2-fill"></i>';
                $editBtn .= '</button></a>';

                $deleteBtn = '<form action="' . route('superadmin.testing.destroy', $query->id) . '" method="POST">';
                $deleteBtn .= csrf_field();
                $deleteBtn .= method_field('DELETE');
                $deleteBtn .= '<button class="btn btn-danger delete-item mx-1" type="submit"><i class="ri-delete-bin-fill"></i></button>';
                $deleteBtn .= '</form>';

                $buttonContainer .= $editBtn . $deleteBtn;
                $buttonContainer .= '</div>';

                return $buttonContainer;
            })
            ->addColumn('banner', function ($query) {
                return  $img = "<img width='80px' height='70px' src='" . asset($query->banner) . "'></img>";
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

            ->rawColumns(['banner', 'action', 'status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Testing $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('testing-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            // ->dom('Bfrtip')
            // ->dom('dt-responsive')
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
            Column::make('id')->width(100, 'dt-responsive'),
            Column::make('banner')->width(200, 'dt-responsive'),
            Column::make('type'),
            Column::make('starting_price'),
            Column::make('serial'),
            Column::make('status'),

            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(200)
                ->addClass('text-center'),

        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Testing_' . date('YmdHis');
    }
}
