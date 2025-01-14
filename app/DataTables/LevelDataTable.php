<?php

namespace App\DataTables;

use App\Models\Level;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class LevelDataTable extends DataTable
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
                // $editbtn = '<a href="#" data-bs-toggle="modal"
                // data-bs-target="#editModal onclick="editUser('.$query->id.',\' '.$query->code.' \')"">';
                // $editbtn .= '<button type="button" class="btn btn-primary waves-effect waves-light mx-1">';
                // $editbtn .= '<i class="ri-edit-2-fill"></i>';
                // $editbtn .= '</button></a>';
                $btnContainer = '<div class="d-flex justify-content-center">';

                $editBtn = '<a href="#" data-bs-toggle="modal" data-bs-target="#editModal" onclick="editUser(' . $query->id . ',\' ' . $query->code . ' \', \'' . $query->description . '\', ' . $query->is_active . ')">';
                $editBtn .= '<button type="button" class="btn btn-primary waves-effect waves-light">';
                $editBtn .= '<i class="ri-edit-2-fill"></i>';
                $editBtn .= '</button></a>';

                $deleteBtn = '<form action="' . route('superadmin.levels.destroy', $query->id) . '" method="POST">';
                $deleteBtn .= csrf_field();
                $deleteBtn .= method_field('DELETE');
                $deleteBtn .= '<button class="btn btn-danger delete-item mx-1" type="submit"><i class="ri-delete-bin-fill"></i></button>';
                $deleteBtn .= '</form>';

                $btnContainer .= $editBtn . $deleteBtn;
                $btnContainer .= '</div>';
                return $btnContainer;
            })
            ->addColumn('status', function ($query) {
                if ($query->is_active == 0) {
                    $statusHtml = '<div class="font-size-13">';
                    $statusHtml .= '<span class="badge bg-warning align-middle me-2">Not Active</span>';
                    $statusHtml .= '</div>';
                } elseif ($query->is_active == 1) {
                    $statusHtml = '<div class="font-size-13">';
                    $statusHtml .= '<span class="badge bg-success align-middle me-2">Active</span>';
                    $statusHtml .= '</div>';
                }
                return $statusHtml;
            })
            ->rawColumns(['action', 'status'])
            ->setRowId('id', 'campus');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Level $model): QueryBuilder
    {
        // $query = Level::query();
        // $query->with('campus');
        // return $this->applyScopes($query);
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('level-table')
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
            Column::make('status'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(150)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Level_' . date('YmdHis');
    }
}
