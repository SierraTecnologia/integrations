@if (!empty($orders) && !$orders->isEmpty())
    @if (method_exists($orders,'onEachSide'))
        {{ $orders->onEachSide(10)->links() }}
    @endif
    <table class="table table-striped">
        <thead>
            <tr>
                <td>ID</td>
                <td>Collaborator</td>
                <td>Credit Card</td>
                <td>Price</td>
                @if (!isset($minimo) || !$minimo)
                    <td>Operadora</td>
                    <td>Money</td>
                @endif
                <td>Status</td>
                <td>Created at</td>
                <?php
                $user = \Auth::user();
                if($user && $user->isRoot()) {
                    echo '<td>Client</td>';
                }
                ?>
                <td colspan="1">Action</td>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{$order->id}}</td>
                <td> @if ($order->collaborator)
                    <a href="{{ route('admin.collaborators.show', $order->collaborator->id)}}">{{$order->collaborator->name}}</a>
                @endif </td>
                <td> @if ($order->customer)
                    <a href="{{ route('admin.customers.show', $order->customer->id)}}">{{$order->customer->name}}</a>
                @endif </td>
                <td>{{$order->total}}</td>
                @if (!isset($minimo) || !$minimo)
                    <td>{{is_object($order->operadora)?$order->operadora->name:'Sem Operadora'}}</td>
                    <td>{{is_object($order->money)?$order->money->name:'Nenhum associado'}}</td>
                @endif
                <td>{!!$order->getStatusSpan()!!}</td>
                <td>{{$order->created_at->format('d/m/Y h:i:s')}}</td>
                <?php
                $user = \Auth::user();
                if($user && $user->isRoot() && is_object($order->user)) {
                    echo '<td><a href="'.route('root.users.show', $order->user->id).'">'.$order->user->name.'</td>';
                }
                ?>
                <td>
                    <a href="{{ route('admin.orders.show',$order->id)}}" class="btn btn-primary">Mais Informações</a>
                    <!--<a href="{{ route('admin.orders.edit',$order->id)}}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('admin.orders.destroy', $order->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </form>-->
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if (method_exists($orders,'onEachSide'))
        {{ $orders->onEachSide(10)->links() }}
    @endif
@endif