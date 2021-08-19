<?php

namespace App\DataTables;

use App\Application;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UnconfirmedApplicationDataTable extends DataTable
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
            ->eloquent($query)
            // ->addColumn('action', 'unsupportedapplicationdatatable.action');
            ->addColumn('is_approve', function(Application $application){  
                if($application->is_approve == 'Y'){
                    return 'Berjaya';
                }elseif($application->is_approve == 'N'){
                    return 'Gagal';
                }else{
                    return 'Dalam Proses';
                }
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\App\UnsupportedApplicationDataTable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Application $model)
    {
        $model = $model->newQuery()
        ->whereHas('approvals', function ($query) {
            return $query->where('status',0)
                ->where(function ($query) {
                    $query->whereNull('su_approval')
                        ->orWhere('su_level',1);
                })
                ->with('approved_by')
                ->whereHas('approved_by', function ($query){ 
                    $query->permission('approval-head-department'); 
                });
        })
        ->with('user.profile','user.profile.department','user.profile.position','type')
        ->select('applications.*');

        $user = Auth::user();
        if($user->hasPermissionTo('approval-head-department') && !$user->hasRole('super-admin')){
            $model =  $model->whereHas('user.profile.department',function($query) use ($user){
                    $query->where('id', $user->profile->department->id);
                });
        }
        
        return $model;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('unsupportedapplicationdatatable-table')
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
            Column::make('user.profile.fullname')->title('Nama Penuh'),
            Column::make('type.name')->title('Jenis Permohonan'),
            Column::make('user.profile.phone_no')->title('No. Telefon'),
            Column::make('user.profile.position.name')->title('Jawatan'),
            Column::make('user.profile.department.name')->title('Bahagian/Unit'),
            Column::make('is_approve')->title('Status'),
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
        return 'PermohonanTidakDisokong_' . date('YmdHis');
    }
}
