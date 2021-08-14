<?php

namespace App\DataTables;

// use App\App\UsersDataTable;
use App\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    protected $printPreview = 'transactions.print';

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query);
            // ->addColumn('action', 'usersdatatable.action');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\App\UsersDataTable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        // return $model->newQuery();
        return $model->newQuery()->with('profile','profile.department','profile.position')->select('users.*');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('usersdatatable-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom("<'row'<'col-sm-12 mb-2'<'float-right'B>>>".
                        "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" .
                        "<'row'<'col-sm-12'tr>>" .
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>")            
                    ->orderBy(0,'asc')
                    ->buttons(
                        // Button::make('create'),
                        Button::make('export'),
                        Button::make('print'),
                        // Button::make('reset'),
                        // Button::make('reload')
                    )
                    ->language(['url' => url('//cdn.datatables.net/plug-ins/1.10.24/i18n/Malay.json')]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            // Column::computed('action')
            //       ->exportable(false)
            //       ->printable(false)
            //       ->width(60)
            //       ->addClass('text-center'),
            // Column::make('id'),
            Column::make('profile.fullname')->title('Nama Penuh'),
            Column::make('name')->title('Nama Pengguna'),
            Column::make('email')->title('E-mel'),
            Column::make('profile.phone_no')->title('No. Telefon'),
            Column::make('profile.position.name')->title('Jawatan'),
            Column::make('profile.department.name')->title('Bahagian/Unit'),
            Column::make('created_at')->title('Dicipta pada'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Pengguna_' . date('YmdHis');
    }
}
