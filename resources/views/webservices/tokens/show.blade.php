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

            <div class="col-xs-12 col-sm-12 col-md-12"><div class="box card box-solid">
                    <div class="box-header card-header with-border">
                        <i class="fa fa-text-width"></i>
                
                        <h3 class="box-title card-title">Collaborator</h3>
                      </div>
                      <!-- /.box-header card-header -->
                      <div class="box-body card-body">
                        <blockquote>
                
                                <a href="{{ route('collaborators.show', $order->collaborator->id)}}">{{$order->collaborator->name}}</a> </blockquote>
                      </div>
                      <!-- /.box-body card-body --></div>
                    </div>
            <div class="col-xs-12 col-sm-12 col-md-12"><div class="box card box-solid">
                    <div class="box-header card-header with-border">
                        <i class="fa fa-text-width"></i>
                
                        <h3 class="box-title card-title">Credit Card</h3>
                      </div>
                      <!-- /.box-header card-header -->
                      <div class="box-body card-body">
                        <blockquote>
                
                                <a href="{{ route('admin.customers.show', $order->customer->id)}}">{{$order->customer->card_number}}</a> </blockquote>
                            </div>
                            <!-- /.box-body card-body --></div>
                          </div>
                    <div class="col-xs-12 col-sm-12 col-md-12"><div class="box card box-solid">
                        <div class="box-header card-header with-border">
                            <i class="fa fa-text-width"></i>
                    
                            <h3 class="box-title card-title">collaborator_info</h3>
                      </div>
                      <!-- /.box-header card-header -->
                      <div class="box-body card-body">
                        <blockquote>
                        
                                        {!! print_r($order->collaborator_info) !!} </blockquote>
                                    </div>
                                    <!-- /.box-body card-body --></div>
                                  </div>

<div class="col-xs-12 col-sm-12 col-md-12"><div class="box card box-solid">
    <div class="box-header card-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title card-title">Order Origin</h3>
      </div>
      <!-- /.box-header card-header -->
      <div class="box-body card-body">
        <blockquote>

                {!! $order->site !!} </blockquote>
      </div>
      <!-- /.box-body card-body --></div>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box card box-solid">
    <div class="box-header card-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title card-title">card_description</h3>
      </div>
      <!-- /.box-header card-header -->
      <div class="box-body card-body">
        <blockquote>

                {!! $order->card_description !!} </blockquote>
      </div>
      <!-- /.box-body card-body --></div>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box card box-solid">
    <div class="box-header card-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title card-title">reference</h3>
      </div>
      <!-- /.box-header card-header -->
      <div class="box-body card-body">
        <blockquote>

                {!! $order->reference !!} </blockquote>
      </div>
      <!-- /.box-body card-body --></div>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box card box-solid">
    <div class="box-header card-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title card-title">description</h3>
      </div>
      <!-- /.box-header card-header -->
      <div class="box-body card-body">
        <blockquote>

                {!! $order->description !!} </blockquote>
      </div>
      <!-- /.box-body card-body --></div>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box card box-solid">
    <div class="box-header card-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title card-title">novacao_type_id</h3>
      </div>
      <!-- /.box-header card-header -->
      <div class="box-body card-body">
        <blockquote>

                {!! $order->novacao_type_id !!} </blockquote>
      </div>
      <!-- /.box-body card-body --></div>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box card box-solid">
    <div class="box-header card-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title card-title">money_id</h3>
      </div>
      <!-- /.box-header card-header -->
      <div class="box-body card-body">
        <blockquote>

                {!! $order->money_id !!} </blockquote>
      </div>
      <!-- /.box-body card-body --></div>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box card box-solid">
    <div class="box-header card-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title card-title">user_token</h3>
      </div>
      <!-- /.box-header card-header -->
      <div class="box-body card-body">
        <blockquote>

                {!! $order->user_token !!} </blockquote>
      </div>
      <!-- /.box-body card-body --></div>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box card box-solid">
    <div class="box-header card-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title card-title">total</h3>
      </div>
      <!-- /.box-header card-header -->
      <div class="box-body card-body">
        <blockquote>

                {!! $order->total !!}
            </blockquote>
      </div>
      <!-- /.box-body card-body --></div>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box card box-solid">
    <div class="box-header card-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title card-title">installments</h3>
      </div>
      <!-- /.box-header card-header -->
      <div class="box-body card-body">
        <blockquote>

                {!! $order->installments !!} </blockquote>
      </div>
      <!-- /.box-body card-body --></div>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box card box-solid">
    <div class="box-header card-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title card-title">status</h3>
      </div>
      <!-- /.box-header card-header -->
      <div class="box-body card-body">
        <blockquote>

                {!! $order->status !!}

</div>

</div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box card box-solid">
    <div class="box-header card-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title card-title">device_token</h3>
      </div>
      <!-- /.box-header card-header -->
      <div class="box-body card-body">
        <blockquote>

                {!! $order->device_token !!} </blockquote>
      </div>
      <!-- /.box-body card-body --></div>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box card box-solid">
    <div class="box-header card-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title card-title">device</h3>
      </div>
      <!-- /.box-header card-header -->
      <div class="box-body card-body">
        <blockquote>

                {!! $order->device !!} </blockquote>
      </div>
      <!-- /.box-body card-body --></div>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box card box-solid">
    <div class="box-header card-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title card-title">operadora</h3>
      </div>
      <!-- /.box-header card-header -->
      <div class="box-body card-body">
        <blockquote>

                {{ empty($order->operadora)?'Sem Operadora':$order->operadora->name }} </blockquote>
      </div>
      <!-- /.box-body card-body --></div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12"><div class="box card box-solid">
        <div class="box-header card-header with-border">
            <i class="fa fa-text-width"></i>
    
            <h3 class="box-title card-title">operadora_mundipagg_public</h3>
          </div>
          <!-- /.box-header card-header -->
          <div class="box-body card-body">
            <blockquote>
    
                    {!! $order->operadora_mundipagg_public !!} </blockquote>
                </div>
                <!-- /.box-body card-body --></div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-12"><div class="box card box-solid">
                  <div class="box-header card-header with-border">
                      <i class="fa fa-text-width"></i>
              
                      <h3 class="box-title card-title">operadora_mundipagg_secret</h3>
                    </div>
                    <!-- /.box-header card-header -->
                    <div class="box-body card-body">
                      <blockquote>
              
                              {!! $order->operadora_mundipagg_secret !!} </blockquote>
                          </div>
                          <!-- /.box-body card-body --></div>
                        </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box card box-solid">
    <div class="box-header card-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title card-title">operadora_pagseguro_public</h3>
      </div>
      <!-- /.box-header card-header -->
      <div class="box-body card-body">
        <blockquote>

                {!! $order->operadora_pagseguro_public !!} </blockquote>
            </div>
            <!-- /.box-body card-body --></div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12"><div class="box card box-solid">
              <div class="box-header card-header with-border">
                  <i class="fa fa-text-width"></i>
          
                  <h3 class="box-title card-title">operadora_pagseguro_secret</h3>
                </div>
                <!-- /.box-header card-header -->
                <div class="box-body card-body">
                  <blockquote>
          
                          {!! $order->operadora_pagseguro_secret !!} </blockquote>
                      </div>
                      <!-- /.box-body card-body --></div>
                    </div>
          <div class="col-xs-12 col-sm-12 col-md-12"><div class="box card box-solid">
              <div class="box-header card-header with-border">
                  <i class="fa fa-text-width"></i>
          
                  <h3 class="box-title card-title">operadora_rede_public</h3>
                </div>
                <!-- /.box-header card-header -->
                <div class="box-body card-body">
                  <blockquote>
          
                          {!! $order->operadora_rede_public !!} </blockquote>
                      </div>
                      <!-- /.box-body card-body --></div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12"><div class="box card box-solid">
                        <div class="box-header card-header with-border">
                            <i class="fa fa-text-width"></i>
                    
                            <h3 class="box-title card-title">operadora_rede_secret</h3>
                          </div>
                          <!-- /.box-header card-header -->
                          <div class="box-body card-body">
                            <blockquote>
                    
                                    {!! $order->operadora_rede_secret !!} </blockquote>
                                </div>
                                <!-- /.box-body card-body --></div>
                              </div>
                    <div class="col-xs-12 col-sm-12 col-md-12"><div class="box card box-solid">
                        <div class="box-header card-header with-border">
                            <i class="fa fa-text-width"></i>
                    
                            <h3 class="box-title card-title">operadora_cielo_public</h3>
                          </div>
                          <!-- /.box-header card-header -->
                          <div class="box-body card-body">
                            <blockquote>
                    
                                    {!! $order->operadora_cielo_public !!} </blockquote>
                                </div>
                                <!-- /.box-body card-body --></div>
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-12"><div class="box card box-solid">
                                  <div class="box-header card-header with-border">
                                      <i class="fa fa-text-width"></i>
                              
                                      <h3 class="box-title card-title">operadora_cielo_secret</h3>
                                    </div>
                                    <!-- /.box-header card-header -->
                                    <div class="box-body card-body">
                                      <blockquote>
                              
                                              {!! $order->operadora_cielo_secret !!} </blockquote>
                                          </div>
                                          <!-- /.box-body card-body --></div>
                                        </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box card box-solid">
    <div class="box-header card-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title card-title">Novação Seguros Token</h3>
      </div>
      <!-- /.box-header card-header -->
      <div class="box-body card-body">
        <blockquote>

{!! $order->tid !!} </blockquote>
</div>
<!-- /.box-body card-body --></div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box card box-solid">
    <div class="box-header card-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title card-title">Bank Slip Id</h3>
      </div>
      <!-- /.box-header card-header -->
      <div class="box-body card-body">
        <blockquote>

{!! $order->bank_slip_id !!} </blockquote>
      </div>
      <!-- /.box-body card-body --></div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12"><div class="box card box-solid">
        <div class="box-header card-header with-border">
            <i class="fa fa-text-width"></i>
    
            <h3 class="box-title card-title">Fraud Analysis Integration</h3>
          </div>
          <!-- /.box-header card-header -->
          <div class="box-body card-body">
            <blockquote>
    
                {{ empty($order->fraudAnalysi)?'Sem anti Fraude':$order->fraudAnalysi->name }} </blockquote>
          </div>
          <!-- /.box-body card-body --></div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12"><div class="box card box-solid">
            <div class="box-header card-header with-border">
                <i class="fa fa-text-width"></i>
        
                <h3 class="box-title card-title">Fraud Analysis Information</h3>
              </div>
              <!-- /.box-header card-header -->
              <div class="box-body card-body">
                <blockquote>
        
                    {{ print_r($order->fraud_analysis) }} </blockquote>
              </div>
              <!-- /.box-body card-body --></div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12"><div class="box card box-solid">
                <div class="box-header card-header with-border">
                    <i class="fa fa-text-width"></i>
            
                    <h3 class="box-title card-title">Konduto Token</h3>
                  </div>
                  <!-- /.box-header card-header -->
                  <div class="box-body card-body">
                    <blockquote>
            
            {!! $order->frauds_konduto_secret !!} </blockquote>
                  </div>
                  <!-- /.box-body card-body --></div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12"><div class="box card box-solid">
                    <div class="box-header card-header with-border">
                        <i class="fa fa-text-width"></i>
                
                        <h3 class="box-title card-title">Clearsale Token</h3>
                      </div>
                      <!-- /.box-header card-header -->
                      <div class="box-body card-body">
                        <blockquote>
                
                {!! $order->frauds_clearsale_secret !!} </blockquote>
                      </div>
                      <!-- /.box-body card-body --></div>
                    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box card box-solid">
    <div class="box-header card-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title card-title">tax_id</h3>
      </div>
      <!-- /.box-header card-header -->
      <div class="box-body card-body">
        <blockquote>

{!! $order->tax_id !!} </blockquote>
      </div>
      <!-- /.box-body card-body --></div>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box card box-solid">
    <div class="box-header card-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title card-title">billing_name</h3>
      </div>
      <!-- /.box-header card-header -->
      <div class="box-body card-body">
        <blockquote>

{!! $order->billing_name !!} </blockquote>
      </div>
      <!-- /.box-body card-body --></div>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box card box-solid">
    <div class="box-header card-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title card-title">billing_address</h3>
      </div>
      <!-- /.box-header card-header -->
      <div class="box-body card-body">
        <blockquote>

{!! $order->billing_address !!} </blockquote>
      </div>
      <!-- /.box-body card-body --></div>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box card box-solid">
    <div class="box-header card-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title card-title">billing_complement</h3>
      </div>
      <!-- /.box-header card-header -->
      <div class="box-body card-body">
        <blockquote>

{!! $order->billing_complement !!} </blockquote>
      </div>
      <!-- /.box-body card-body --></div>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box card box-solid">
    <div class="box-header card-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title card-title">billing_city</h3>
      </div>
      <!-- /.box-header card-header -->
      <div class="box-body card-body">
        <blockquote>

{!! $order->billing_city !!} </blockquote>
      </div>
      <!-- /.box-body card-body --></div>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box card box-solid">
    <div class="box-header card-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title card-title">billing_state</h3>
      </div>
      <!-- /.box-header card-header -->
      <div class="box-body card-body">
        <blockquote>

{!! $order->billing_state !!} </blockquote>
      </div>
      <!-- /.box-body card-body --></div>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box card box-solid">
    <div class="box-header card-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title card-title">billing_zip</h3>
      </div>
      <!-- /.box-header card-header -->
      <div class="box-body card-body">
        <blockquote>

{!! $order->billing_zip !!} </blockquote>
      </div>
      <!-- /.box-body card-body --></div>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box card box-solid">
    <div class="box-header card-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title card-title">billing_country</h3>
      </div>
      <!-- /.box-header card-header -->
      <div class="box-body card-body">
        <blockquote>

{!! $order->billing_country !!} </blockquote>
      </div>
      <!-- /.box-body card-body --></div>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box card box-solid">
    <div class="box-header card-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title card-title">created_at</h3>
      </div>
      <!-- /.box-header card-header -->
      <div class="box-body card-body">
        <blockquote>

{!! $order->created_at !!} </blockquote>
      </div>
      <!-- /.box-body card-body --></div>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box card box-solid">
    <div class="box-header card-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title card-title">updated_at</h3>
      </div>
      <!-- /.box-header card-header -->
      <div class="box-body card-body">
        <blockquote>

{!! $order->updated_at !!} </blockquote>
      </div>
      <!-- /.box-body card-body --></div>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12"><div class="box card box-solid">
    <div class="box-header card-header with-border">
        <i class="fa fa-text-width"></i>

        <h3 class="box-title card-title">user_id</h3>
      </div>
      <!-- /.box-header card-header -->
      <div class="box-body card-body">
        <blockquote>

{!! $order->user_id !!} </blockquote>
      </div>
      <!-- /.box-body card-body --></div>
    </div>
    </div>

@endsection