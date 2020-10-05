<?php

namespace Integrations\Http\Controllers\WebServicos;

use Illuminate\Http\Request;
use Integrations\Exceptions\Exception;
use Integrations\Http\Controllers\Controller as Base;
use Integrations\Models\Token;
// use Facilitador\Http\Controllers\Admin\Base;
use Yajra\Datatables\Datatables;

class TokenController extends Base
{
    /**
     * @var string
     */
    public $title = 'Tokens';
    public $model = Token::class;

    /**
     * @var string
     */
    public $description = 'Listagem de Tokens.';

    /**
     * @var array
     */
    public $columns = [
        'Rule' => 'getAdminTitleAttribute',
    ];

    /**
     * @var array
     */
    public $search = [
        'from',
        'to',
        'code' => [
            'type' => 'select',
            'options' => 'Facilitador\Models\RedirectRule::getCodes()',
        ],
        'label',
    ];

    /**
     * Get the permission options.
     *
     * @return array An associative array.
     */
    public function getPermissionOptions()
    {
        return array_except(parent::getPermissionOptions(), ['publish']);
    }

    /**
     * Populate protected properties on init
     */
    public function __construct()
    {
        $this->title = __('pedreiro::redirect_rules.controller.title');
        $this->description = __('pedreiro::redirect_rules.controller.description');
        $this->columns = [
            __('pedreiro::redirect_rules.controller.column.rule') => 'getAdminTitleAttribute',
        ];
        $this->search = [
            'from' => [
                'label' => __('pedreiro::redirect_rules.controller.search.from'),
                'type' => 'text',
            ],
            'to' => [
                'label' => __('pedreiro::redirect_rules.controller.search.to'),
                'type' => 'text',
            ],
            'code' => [
                'label' => __('pedreiro::redirect_rules.controller.search.code'),
                'type' => 'select',
                'options' => 'Facilitador\Models\RedirectRule::getCodes()',
            ],
            'label' => [
                'label' => __('pedreiro::redirect_rules.controller.search.label'),
                'type' => 'text',
            ],
        ];

        // parent::__construct();
    }

    // /**
    //  * @var string
    //  */
    // public $description = "Listagem de Pedidos.";

    // /**
    //  * Display all the workers
    //  *
    //  * @return Illuminate\View\View
    //  */
    // public function index(Request $request)
    // {
    //     return $this->populateView(
    //         'admin.orders.index', [
    //         'orders' => Order::orderBy('id', 'DESC')->simplePaginate(50),
    //         ]
    //     );
    // }

    // /**
    //  * Ajax service that tails the log file for the selected worker
    //  *
    //  * @param $worker
    //  */
    // public function tail($worker)
    // {
    //     // Form the path to the file
    //     $file = Worker::logPath(urldecode($worker));
    //     if (!file_exists($file)) {
    //         throw new Exception('Log not found: '.$file);
    //     }
    //     $size = 1024 * 100; // in bytes to get

    //     // Read from the end of the file
    //     clearstatcache();
    //     $fp = fopen($file, 'r');
    //     fseek($fp, -$size, SEEK_END);
    //     $contents = explode("\n", fread($fp, $size));
    //     fclose($fp);

    //     // Reverse the contents and return
    //     $contents = array_reverse($contents);
    //     if (empty($contents[0])) {
    //         array_shift($contents);
    //     }
    //     die(implode("\n", $contents));
    // }

    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function index(Request $request)
    // {
    //     // if ($request->ajax()) {
    //     //     $query = Order::with('user', 'operadora', 'collaborator', 'customer', 'money')->select('orders.*');

    //     //     return Datatables::of($query)->addColumn('action', function ($order) {
    //     //         return '<a href="'.route('admin.orders.show',$order->id).'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-eye"></i> Show</a>';
    //     //     })->setRowId('id')->editColumn('created_at', function ($order) {
    //     //         return $order->created_at->format('h:m:s d/m/Y');
    //     //     })
    //     //     ->setRowClass(function ($order) {
    //     //         return $order->status == Order::$STATUS_APPROVED ? 'alert-success' : 'alert-warning';
    //     //     })
    //     //     ->setRowData([
    //     //         'id' => 'test',
    //     //     ])
    //     //     ->setRowAttr([
    //     //         'color' => 'red',
    //     //     ])->make(true);

    //     //     return $this->dataTable->eloquent($query)->make(true);
    //     // }
    //     // return view('admin.orders.index');

    //     // USando Service //public function index(UsersDataTable $dataTable)
    //     // return $dataTable->render('orders.index');

    //     if ($request->has('query') && !empty($request->input('query'))) {
    //         dd('oi');
    //         $orders = Order::search($request->input('query'))->orderBy('id', 'DESC')->simplePaginate(50);
    //     } else {
    //         $orders = Order::orderBy('id', 'DESC')->simplePaginate(50);
    //     }
    //     return view('admin.orders.index', compact('orders'));
    // }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     return view('admin.orders.create');
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //   $request->validate([
    //     'total'=>'required',
    //     'money'=> 'required|integer',
    //     'operadora' => 'required|integer'
    //   ]);
    //   $order = new Order([
    //     'total' => $request->get('total'),
    //     'money'=> $request->get('money'),
    //     'operadora'=> $request->get('operadora')
    //   ]);
    //   $order->save();
    //   return redirect('/orders')->with('success', 'Stock has been added');
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show(Request $request, $id)
    // {
    //     $order = Order::findOrFail($id);
    //     return view('admin.orders.show', compact('order'));
    // }
    

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit(Request $request, $id)
    // {
    //     $order = Order::find($id);

    //     return view('admin.orders.edit', compact('order'));
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'total'=>'required',
    //         'money'=> 'required|integer',
    //         'operadora' => 'required|integer'
    //     ]);

    //     $order = Order::findOrFail($id);
    //     $order->total = $request->get('total');
    //     $order->money = $request->get('money');
    //     $order->operadora = $request->get('operadora');
    //     $order->save();

    //     return redirect('/orders')->with('success', 'Stock has been updated');
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy(Request $request, $id)
    // {
    //     $order = Order::findOrFail($id);
    //     $order->delete();

    //     return redirect('/orders')->with('success', 'Stock has been deleted Successfully');
    // }
}
