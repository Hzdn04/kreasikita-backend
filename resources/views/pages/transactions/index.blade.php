@extends('layouts.default')

@section('content')
    <div class="orders">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">Daftar Transaksi Masuk</h4>
                    </div>
                    <div class="card-body--">
                        <div class="table-stats order-table ov-h">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Nomor</th>
                                        <th>Total Transaksi</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   @forelse ($items as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->number }}</td>
                                            <td>{{ $item->transaction_total }}</td>
                                            <td>
                                                @if ($item->transaction_status == 'PENDING')
                                                    <span class="badge badge-info">                                
                                                        @elseif ($item->transaction_status == 'SUCCESS')
                                                            <span class="badge badge-success">
                                                        @elseif ($item->transaction_status == 'FAILED')
                                                            <span class="badge badge-warning">
                                                        @else
                                                            <span>    
                                                        @endif   
                                                        {{ $item->transaction_status}} 
                                                    </span>
                                            </td>
                                            <td>
                                                {{--  --}}
                                                @if ($item->transaction_status == 'PENDING')
                                                    <a href="{{ route('transactions.status', $item->id) }}?status=SUCCESS" class="btn btn-success btn-sm">
                                                        <i class="fa fa-check"></i>
                                                    </a>
                                                    <a href="{{ route('transactions.status', $item->id) }}?status=FAILED" class="btn btn-warning btn-sm">
                                                        <i class="fa fa-times"></i>
                                                    </a>
                                                @endif
                                                <a href="#mymodal"
                                                    data-remote="{{ route('transactions.show', $item->id) }}"
                                                    data-toggle="modal"
                                                    data-target="#mymodal{{$item->id}}"
                                                    data-title="Detail Transaksi {{ $item->uuid }}"
                                                   class="btn btn-primary btn-sm">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('transactions.edit', $item->id) }}" class="btn btn-primary btn-sm">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <form action="{{ route('transactions.destroy', $item->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-danger btn-sm">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>

                                        

                                   @empty
                                       <tr>
                                           <td colspan="6" class="text-center p-5">
                                            Data Kosong
                                           </td>
                                       </tr>
                                   @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach ($items as $item)
    <div class="modal fade" id="mymodal{{$item->id}}" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h5 class="modal-title" id="">{{$item->uuid}}</h5>
            </div>
            <div class="modal-body">
              <table class="table table-bordered">
                <tr>
                    <th>Nama</th>
                    <td>{{ $item->name}}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $item->email}}</td>
                </tr>
                <tr>
                    <th>Nomor</th>
                    <td>{{ $item->number}}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>{{ $item->address}}</td>
                </tr>
                <tr>
                    <th>Total Transaksi</th>
                    <td>{{ $item->transaction_total}}</td>
                </tr>
                <tr>
                    <th>Status Transaksi</th>
                    <td>{{ $item->transaction_status}}</td>
                </tr>
                <tr>
                    <th>Pembelian Produk</th>
                    <td>
                        <table class="table table-bordered w-100">
                            <tr>
                                <th>Nama</th>
                                <th>Tipe</th>
                                <th>Harga</th>
                            </tr>
                            @foreach ($item->details as $detail)
                                <tr>
                                    <td>{{ $detail->product->name }}</td>
                                    <td>{{ $detail->product->type }}</td>
                                    <td>Rp.{{ $detail->product->price }}</td>
                                </tr>
                            @endforeach
                        </table>             
                    </td>
                </tr>
            </table>
            <div class="row">
                <div class="col-4">
                    <a href="{{ route('transactions.status', $item->id) }}?status=SUCCESS" class="btn btn-success btn-block">
                        <i class="fa fa-icon"></i> Set Success
                    </a>
                </div>
                <div class="col-4">
                    <a href="{{ route('transactions.status', $item->id) }}?status=FAILED" class="btn btn-warning btn-block">
                        <i class="fa fa-times"></i> Set Gagal
                    </a>
                </div>
                <div class="col-4">
                    <a href="{{ route('transactions.status', $item->id) }}?status=PENDING" class="btn btn-success btn-info">
                        <i class="fa fa-spinner"></i> Set Pending
                    </a>
                </div>
            </div>
            </div>
          </div>
        </div>
      </div>
    @endforeach
@endsection