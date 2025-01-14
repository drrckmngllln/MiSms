<?php

namespace App\DataTables;

use App\Models\laboratoryModel;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class laboratoryModelDataTable extends DataTable
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

                $editbtn = '<a href="#" data-bs-toggle="modal" data-bs-target="#editLabFee" onclick="editLaboratoryFee
                (' . $query->id . ', \'' . $query->category . '\', \'' . $query->description . '\', \'' . $query->campus_id . '\', 
                \'' . $query->first_year . '\', \'' . $query->second_year . '\', \'' . $query->third_year . '\', \'' . $query->fourth_year . '\',
                \'' . $query->semester . '\', \'' . $query->course_id . '\')">';
                $editbtn .= '<button type="button" class="btn btn-primary waves-effect waves-light">';
                $editbtn .= '<i class="ri-edit-2-fill"></i>';
                $editbtn .= '</button></a>';

                $deletebtn = '<form action="' . route('superadmin.laboratory.destroy', $query->id) . '" method="POST">';
                $deletebtn .= csrf_field();
                $deletebtn .= method_field('DELETE');
                $deletebtn .= '<button class="btn btn-danger delete-item mx-1" type="submisst"><i class="ri-delete-bin-fill"></i></button>';
                $deletebtn .= '</form>';

                $linkedSub = '<a href="#" data-bs-toggle="modal" data-bs-target="#linkedSubjectModal" onclick="subjectLinked
                (' . $query->id . ')">';
                $linkedSub .= '<button type="button" class="btn btn-primary waves-effect waves-light">';
                $linkedSub .= '<i class="ri-links-fill"></i>';
                $linkedSub .= '</button></a>';

                $viewSubLinked = '<a href="#" data-bs-toggle="modal" data-bs-target="#viewLinkedSubject" onclick="viewsubjectLinked(' . $query->id . ')">';
                $viewSubLinked .= '<button type="button" class="btn btn-primary waves-effect waves-light mx-1">';
                $viewSubLinked .= '<i class="ri-eye-fill"></i>';
                $viewSubLinked .= '</button></a>';

                $btncontainer .= $editbtn . $deletebtn . $linkedSub . $viewSubLinked;
                $btncontainer .= '</div>';
                return $btncontainer;
            })
            ->addColumn('campus', function ($query) {
                return $query?->campus?->code;
            })
            ->addColumn('course', function ($query) {
                return $query?->course?->code;
            })
            ->filterColumn('campus', function ($query, $keyword) {
                $query->whereHas('campus', function ($q) use ($keyword) {
                    $q->where('code', 'like', "%{$keyword}%");
                });
            })
            ->editColumn('first_year', function ($row) {
                return number_format($row->first_year, 2);
            })
            ->editColumn('second_year', function ($row) {
                return number_format($row->second_year, 2);
            })
            ->addColumn('third_year', function ($row) {
                return number_format($row->third_year, 2);
            })
            ->addColumn('fourth_year', function ($row) {
                return number_format($row->fourth_year, 2);
            })
            ->setRowId('id', 'campus');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(laboratoryModel $model): QueryBuilder
    {
        // return $model->newQuery();
        $query = laboratoryModel::query();
        $query->with('campus');
        return $this->applyScopes($query);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('laboratorymodel-table')
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
            Column::make('description'),
            Column::make('semester'),

            Column::make('campus'),
            Column::make('first_year'),
            Column::make('second_year'),
            Column::make('third_year'),
            Column::make('fourth_year'),
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
        return 'laboratoryModel_' . date('YmdHis');
    }
}
