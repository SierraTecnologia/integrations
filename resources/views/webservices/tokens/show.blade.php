@extends('layouts.page')

@section('title', 'Show Order')

@section('content_header')
    <h1>Show Order</h1>
@stop

@section('css')

@stop

@section('js')

@stop

@section('content')

    <div class="row">

        <div class="col-lg-12 margin-tb">

            <div class="pull-left">

                <h2> Show Order</h2>

            </div>

            <div class="pull-right">

                <a class="btn btn-primary" href="{{ route('admin.orders.index') }}"> Back</a>

            </div>

        </div>

    </div>

   

    <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-12"><div class="box box-solid">
                    <div class="box-header with-border">
                        <i class="fa fa-text-width"></i>
                
                        <h3 class="box-title">Collaborator</h3>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                        <blockquote>
                
                                <a href="{{ route('collaborators.show', $order->collaborator->id)}}">{{$order->collaborator->name}}</a> </blockquote>
                      </div>
                      <!-- /.box-body --></div>
                    </div>
            <div class="col-xs-12 col-sm-12 col-md-12"><div class="box box-solid">
                    <div class="box-header with-border">
                        <i class="fa fa-text-width"></i>
                
                        <h3 class="box-title">Credit Card</h3>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                        <blockquote>
                
                                <a href="{{ route('admin.customers.show', $order->customer->id)}}">{{$order->customer->card_number}}</a> </blockquote>
                            </div>
                            <!-- /.box-body --></div>
                          </div>
                    <div class="col-xs-12 col-sm-12 col-md-12"><div class="box box-solid">
                        <div class="box-header with-border">
                            <i class="fa fa-text-width"></i>
                    
                            <h3 class="box-title">collaborator_info</h3>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                        <blockquote>
                        
                                        {!! print_r($order->collaborator_info) !!} </blockquote>
                                    </div>
                                    <!-- /.box-body --></div>
                                  </div>

<div class="col-xs-12 col-sm-12 col-md-12"><div class="box box-solid">
    <div class="box-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title">Order Origin</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <blockquote>

                {!! $order->site !!} </blockquote>
      </div>
      <!-- /.box-body --></div>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box box-solid">
    <div class="box-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title">card_description</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <blockquote>

                {!! $order->card_description !!} </blockquote>
      </div>
      <!-- /.box-body --></div>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box box-solid">
    <div class="box-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title">reference</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <blockquote>

                {!! $order->reference !!} </blockquote>
      </div>
      <!-- /.box-body --></div>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box box-solid">
    <div class="box-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title">description</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <blockquote>

                {!! $order->description !!} </blockquote>
      </div>
      <!-- /.box-body --></div>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box box-solid">
    <div class="box-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title">novacao_type_id</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <blockquote>

                {!! $order->novacao_type_id !!} </blockquote>
      </div>
      <!-- /.box-body --></div>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box box-solid">
    <div class="box-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title">money_id</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <blockquote>

                {!! $order->money_id !!} </blockquote>
      </div>
      <!-- /.box-body --></div>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box box-solid">
    <div class="box-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title">user_token</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <blockquote>

                {!! $order->user_token !!} </blockquote>
      </div>
      <!-- /.box-body --></div>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box box-solid">
    <div class="box-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title">total</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <blockquote>

                {!! $order->total !!}
            </blockquote>
      </div>
      <!-- /.box-body --></div>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box box-solid">
    <div class="box-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title">installments</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <blockquote>

                {!! $order->installments !!} </blockquote>
      </div>
      <!-- /.box-body --></div>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box box-solid">
    <div class="box-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title">status</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <blockquote>

                {!! $order->status !!}

</div>

</div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box box-solid">
    <div class="box-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title">device_token</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <blockquote>

                {!! $order->device_token !!} </blockquote>
      </div>
      <!-- /.box-body --></div>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box box-solid">
    <div class="box-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title">device</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <blockquote>

                {!! $order->device !!} </blockquote>
      </div>
      <!-- /.box-body --></div>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box box-solid">
    <div class="box-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title">operadora</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <blockquote>

                {{ empty($order->operadora)?'Sem Operadora':$order->operadora->name }} </blockquote>
      </div>
      <!-- /.box-body --></div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12"><div class="box box-solid">
        <div class="box-header with-border">
            <i class="fa fa-text-width"></i>
    
            <h3 class="box-title">operadora_mundipagg_public</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <blockquote>
    
                    {!! $order->operadora_mundipagg_public !!} </blockquote>
                </div>
                <!-- /.box-body --></div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-12"><div class="box box-solid">
                  <div class="box-header with-border">
                      <i class="fa fa-text-width"></i>
              
                      <h3 class="box-title">operadora_mundipagg_secret</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <blockquote>
              
                              {!! $order->operadora_mundipagg_secret !!} </blockquote>
                          </div>
                          <!-- /.box-body --></div>
                        </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box box-solid">
    <div class="box-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title">operadora_pagseguro_public</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <blockquote>

                {!! $order->operadora_pagseguro_public !!} </blockquote>
            </div>
            <!-- /.box-body --></div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12"><div class="box box-solid">
              <div class="box-header with-border">
                  <i class="fa fa-text-width"></i>
          
                  <h3 class="box-title">operadora_pagseguro_secret</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <blockquote>
          
                          {!! $order->operadora_pagseguro_secret !!} </blockquote>
                      </div>
                      <!-- /.box-body --></div>
                    </div>
          <div class="col-xs-12 col-sm-12 col-md-12"><div class="box box-solid">
              <div class="box-header with-border">
                  <i class="fa fa-text-width"></i>
          
                  <h3 class="box-title">operadora_rede_public</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <blockquote>
          
                          {!! $order->operadora_rede_public !!} </blockquote>
                      </div>
                      <!-- /.box-body --></div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12"><div class="box box-solid">
                        <div class="box-header with-border">
                            <i class="fa fa-text-width"></i>
                    
                            <h3 class="box-title">operadora_rede_secret</h3>
                          </div>
                          <!-- /.box-header -->
                          <div class="box-body">
                            <blockquote>
                    
                                    {!! $order->operadora_rede_secret !!} </blockquote>
                                </div>
                                <!-- /.box-body --></div>
                              </div>
                    <div class="col-xs-12 col-sm-12 col-md-12"><div class="box box-solid">
                        <div class="box-header with-border">
                            <i class="fa fa-text-width"></i>
                    
                            <h3 class="box-title">operadora_cielo_public</h3>
                          </div>
                          <!-- /.box-header -->
                          <div class="box-body">
                            <blockquote>
                    
                                    {!! $order->operadora_cielo_public !!} </blockquote>
                                </div>
                                <!-- /.box-body --></div>
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-12"><div class="box box-solid">
                                  <div class="box-header with-border">
                                      <i class="fa fa-text-width"></i>
                              
                                      <h3 class="box-title">operadora_cielo_secret</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                      <blockquote>
                              
                                              {!! $order->operadora_cielo_secret !!} </blockquote>
                                          </div>
                                          <!-- /.box-body --></div>
                                        </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box box-solid">
    <div class="box-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title">Novação Seguros Token</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <blockquote>

{!! $order->tid !!} </blockquote>
</div>
<!-- /.box-body --></div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box box-solid">
    <div class="box-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title">Bank Slip Id</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <blockquote>

{!! $order->bank_slip_id !!} </blockquote>
      </div>
      <!-- /.box-body --></div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12"><div class="box box-solid">
        <div class="box-header with-border">
            <i class="fa fa-text-width"></i>
    
            <h3 class="box-title">Fraud Analysis Integration</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <blockquote>
    
                {{ empty($order->fraudAnalysi)?'Sem anti Fraude':$order->fraudAnalysi->name }} </blockquote>
          </div>
          <!-- /.box-body --></div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12"><div class="box box-solid">
            <div class="box-header with-border">
                <i class="fa fa-text-width"></i>
        
                <h3 class="box-title">Fraud Analysis Information</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <blockquote>
        
                    {{ print_r($order->fraud_analysis) }} </blockquote>
              </div>
              <!-- /.box-body --></div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12"><div class="box box-solid">
                <div class="box-header with-border">
                    <i class="fa fa-text-width"></i>
            
                    <h3 class="box-title">Konduto Token</h3>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                    <blockquote>
            
            {!! $order->frauds_konduto_secret !!} </blockquote>
                  </div>
                  <!-- /.box-body --></div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12"><div class="box box-solid">
                    <div class="box-header with-border">
                        <i class="fa fa-text-width"></i>
                
                        <h3 class="box-title">Clearsale Token</h3>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                        <blockquote>
                
                {!! $order->frauds_clearsale_secret !!} </blockquote>
                      </div>
                      <!-- /.box-body --></div>
                    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box box-solid">
    <div class="box-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title">tax_id</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <blockquote>

{!! $order->tax_id !!} </blockquote>
      </div>
      <!-- /.box-body --></div>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box box-solid">
    <div class="box-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title">billing_name</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <blockquote>

{!! $order->billing_name !!} </blockquote>
      </div>
      <!-- /.box-body --></div>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box box-solid">
    <div class="box-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title">billing_address</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <blockquote>

{!! $order->billing_address !!} </blockquote>
      </div>
      <!-- /.box-body --></div>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box box-solid">
    <div class="box-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title">billing_complement</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <blockquote>

{!! $order->billing_complement !!} </blockquote>
      </div>
      <!-- /.box-body --></div>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box box-solid">
    <div class="box-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title">billing_city</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <blockquote>

{!! $order->billing_city !!} </blockquote>
      </div>
      <!-- /.box-body --></div>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box box-solid">
    <div class="box-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title">billing_state</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <blockquote>

{!! $order->billing_state !!} </blockquote>
      </div>
      <!-- /.box-body --></div>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box box-solid">
    <div class="box-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title">billing_zip</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <blockquote>

{!! $order->billing_zip !!} </blockquote>
      </div>
      <!-- /.box-body --></div>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box box-solid">
    <div class="box-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title">billing_country</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <blockquote>

{!! $order->billing_country !!} </blockquote>
      </div>
      <!-- /.box-body --></div>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box box-solid">
    <div class="box-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title">created_at</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <blockquote>

{!! $order->created_at !!} </blockquote>
      </div>
      <!-- /.box-body --></div>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box box-solid">
    <div class="box-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title">updated_at</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <blockquote>

{!! $order->updated_at !!} </blockquote>
      </div>
      <!-- /.box-body --></div>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box box-solid">
    <div class="box-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title">user_id</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <blockquote>

{!! $order->user_id !!} </blockquote>
      </div>
      <!-- /.box-body --></div>
    </div>
    </div>

@endsection