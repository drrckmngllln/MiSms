<?php

namespace App\DataTables;

use App\Models\Discount;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DiscountDataTable extends DataTable
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

                $btncontainer = '<div class="d-flex justify-content-center">';

                $editbtn = '<a href="#" data-bs-toggle="modal" data-bs-target="#editMiscfee" onclick="editDiscount
                (' . $query->id . ', \'' . $query->code . '\',\'' . $query->discount_target . '\',
                \'' . $query->description . '\',\'' . $query->discount_percentage . '\', \'' . $query->discount_type . '\',
               \'' . $query->discount_code . '\')">';
                $editbtn .= '<button type="button" class="btn btn-primary waves-effect waves-light">';
                $editbtn .= '<i class="ri-edit-2-fill"></i>';
                $editbtn .= '</button></a>';

                $deletebtn = '<form action="' . route('superadmin.discount.destroy', $query->id) . '" method="POST">';
                $deletebtn .= csrf_field();
                $deletebtn .= method_field('DELETE');
                $deletebtn .= '<button class="btn btn-danger delete-item mx-1" type="submit"><i class="ri-delete-bin-fill"></i></button>';
                $deletebtn .= '</form>';


                $btncontainer .= $editbtn . $deletebtn;
                $btncontainer .= '</div>';
                return $btncontainer;
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Discount $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('discount-table')
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
            Column::make('discount_target'),
            Column::make('description')->title('Remarks'),
            Column::make('discount_type'),
            Column::make('discount_code'),
            Column::make('discount_percentage'),
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
        return 'Discount_' . date('YmdHis');
    }
}