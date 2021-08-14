@extends('adminlte::page')

{{-- @section('title', 'AdminLTE') --}}

@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop

@can('read-users')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-6">
                          <!-- small box -->
                          <div class="small-box bg-info">
                            <div class="inner">
                              <h3>{{app\User::count()}}</h3>
              
                              <p>Jumlah Pengguna</p>
                            </div>
                            <div class="icon">
                              <i class="ion ion-bag"></i>
                            </div>
                          </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                          <!-- small box -->
                          <div class="small-box bg-success">
                            <div class="inner">
                              <h3>{{ App\Application::where('is_approve','Y')->count() }}</h3>
              
                              <p>Permohonan Berjaya</p>
                            </div>
                            <div class="icon">
                              <i class="ion ion-stats-bars"></i>
                            </div>
                          </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                          <!-- small box -->
                          <div class="small-box bg-primary">
                            <div class="inner">
                              <h3>{{ App\Application::where('is_approve',null)->count() }}</h3>
              
                              <p>Permohonan Dalam Proses</p>
                            </div>
                            <div class="icon">
                              <i class="ion ion-person-add"></i>
                            </div>
                          </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                          <!-- small box -->
                          <div class="small-box bg-danger">
                            <div class="inner">
                              <h3>{{ App\Application::where('is_approve','N')->count() }}</h3>
              
                              <p>Permohonan Gagal</p>
                            </div>
                            <div class="icon">
                              <i class="ion ion-pie-graph"></i>
                            </div>
                          </div>
                        </div>
                        <!-- ./col -->
                      </div>
                </div>
            </div>
        </div>
    </div>
@stop
@endcan

@cannot('read-users')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4 col-12">
                      <!-- small box -->
                      <div class="small-box bg-success">
                        <div class="inner">
                          <h3>{{ App\Application::where('user_id', Auth::user()->id)->where('is_approve','Y')->count() }}</h3>
          
                          <p>Permohonan Berjaya</p>
                        </div>
                        <div class="icon">
                          <i class="ion ion-stats-bars"></i>
                        </div>
                      </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-4 col-12">
                      <!-- small box -->
                      <div class="small-box bg-primary">
                        <div class="inner">
                          <h3>{{App\Application::where('user_id', Auth::user()->id)->where('is_approve',null)->count() }}</h3>
          
                          <p>Permohonan Dalam Proses</p>
                        </div>
                        <div class="icon">
                          <i class="ion ion-person-add"></i>
                        </div>
                      </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-4 col-12">
                      <!-- small box -->
                      <div class="small-box bg-danger">
                        <div class="inner">
                          <h3>{{App\Application::where('user_id', Auth::user()->id)->where('is_approve','N')->count()}}</h3>
          
                          <p>Permohonan Gagal</p>
                        </div>
                        <div class="icon">
                          <i class="ion ion-pie-graph"></i>
                        </div>
                      </div>
                    </div>
                    <!-- ./col -->
                  </div>
            </div>
        </div>
    </div>
</div>
@stop
@endcannot