<?php

namespace App\DataTables;

use App\Models\FeesCategory;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class FeesCategoryDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))

            ->addColumn('course', function ($query) {
                return $query->course->description;
            })
            ->addColumn('amount', function ($row) {
                // Assuming $row->amount contains the numeric value
                return '₱ ' . number_format($row->amount, 2); // Format the amount with two decimal places and prepend '₱'
            })
            ->addColumn('action', function ($query) {
                $buttonContainer = '<div class="d-flex justify-content-center">';
                $editBtn = '<a href="#" data-bs-toggle="modal" data-bs-target="#editModal" ' .
                    'onclick="editUser(' . $query->id . ' )">';

                $editBtn .= '<button type="button" class="btn btn-primary waves-effect waves-light">';
                $editBtn .= '<i class="ri-edit-2-fill"></i>';
                $editBtn .= '</button></a>';

                $buttonContainer .= $editBtn;
                $buttonContainer .= '</div>';
                return $buttonContainer;
            });
    }
    //eto yung relationship sa course para makita siya sa yajra table comment outna muna natin


    /**
     * Get the query source of dataTable.
     */
    public function query(FeesCategory $model): QueryBuilder
    {
        $query = FeesCategory::query();
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
            ->setTableId('feescategory-table')
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
            Column::make('category'),
            Column::make('freetype'),
            Column::make('course'),
            Column::make('year_level'),
            Column::make('amount'),
            Column::make('remarks'),
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
        return 'FeesCategory_' . date('YmdHis');
    }
}
