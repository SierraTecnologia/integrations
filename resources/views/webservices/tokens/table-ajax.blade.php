<table class="table table-bordered" id="users-table">
    <thead>
        <tr>
            <td>ID</td>
            <td>Collaborator</td>
            <td>Credit Card</td>
            <td>Price</td>
            <td>Operadora</td>
            <td>Money</td>
            <?php
            $user = \Auth::user();
            if($user && $user->role_id == \App\Models\Role::$GOOD) {
                echo '<td>Client</td>';
            }
            ?>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
    </thead>
</table>

<?php
if($user && $user->role_id == \App\Models\Role::$GOOD) {
    ?>
    @push('scripts')
    <script>
    $(function() {
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('admin.orders.index') !!}',
            columns: [
                { data: 'id', name: 'orders.id' },
                { data: 'collaborator.name', name: 'collaborator.name' },
                { data: 'customer.number', name: 'customer.number' },
                { data: 'total', name: 'orders.total' },
                { data: 'operadora.name', name: 'operadora.name' },
                { data: 'money.name', name: 'money.name' },
                { data: 'user.name', name: 'user.name' },
                { data: 'created_at', name: 'orders.created_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
    </script>
    @endpush
    <?php
} else {
    ?>
    @push('scripts')
    <script>
    $(function() {
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('admin.orders.index') !!}',
            columns: [
                { data: 'id', name: 'orders.id' },
                { data: 'collaborator.name', name: 'collaborator.name' },
                { data: 'customer.number', name: 'customer.number' },
                { data: 'total', name: 'orders.total' },
                { data: 'operadora.name', name: 'operadora.name' },
                { data: 'money.name', name: 'money.name' },
                { data: 'created_at', name: 'orders.created_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
    </script>
    @endpush    
    <?php
}