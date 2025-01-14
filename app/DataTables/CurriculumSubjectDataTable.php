<?php

namespace App\DataTables;

use App\Models\CurriculumSubject;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CurriculumSubjectDataTable extends DataTable
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

                $deletebtn = '<form action="' . route('superadmin.feetype.destroy', $query->id) . '" method="POST">';
                $deletebtn .= csrf_field();
                $deletebtn .= method_field('DELETE');
                $deletebtn .= '<button class="btn btn-danger delete-item mx-1" type="submit"><i class="ri-delete-bin-fill"></i></button>';
                $deletebtn .= '</form>';

                return $deletebtn;
            })

            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(CurriculumSubject $model): QueryBuilder
    {
        return $model->newQuery()->where('curriculum_id', 8);
    }



    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('curriculumsubject-table')
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
            Column::make('year_level'),
            Column::make('semester_id'),
            Column::make('code'),
            Column::make('descriptive_tittle'),
            Column::make('total_units'),
            Column::make('lecture_units'),
            Column::make('lab_units'),
            Column::make('pre_requisite'),
            Column::make('total_hrs_per_week'),
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
        return 'CurriculumSubject_' . date('YmdHis');
    }
}
