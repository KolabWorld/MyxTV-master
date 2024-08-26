@extends('frontend.app')


@section('title') :: @parent @stop

@section('content')

    @include('frontend.partials.nav', [
        'title' => 'Contacts List',
        'description' => count($contacts) . ' Records',
    ])

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row align-items-center">
                        <div class="col-4 d-none d-sm-block">
                            <a href="javascript:history.back()" class="btn btn-outline-secondary">Go Back</a>
                        </div>
                    </div>
                    <div class="dashbed-border-bottom mt-2 mb-3"></div>
                    <div class="row">
                        <div class="col-md-12 ">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table dashtable">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Mobile</th>
                                                    <th>Message</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($contacts as $contact)
                                                    <tr>
                                                        <td>
                                                            <span class="badge 
                                                            @if($contact->status == 'active')
                                                                badge-success
                                                            @elseif($contact->status == 'inactive')
                                                                badge-danger
                                                            @else
                                                                badge-warning
                                                            @endif
                                                            ">
                                                                {{ ucWords($contact->status) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            {{ $contact->name }}
                                                        </td>
                                                        <td>
                                                            {{ $contact->email }}
                                                        </td>
                                                        <td>
                                                            {{ $contact->mobile }}
                                                        </td>
                                                        <td>
                                                            {!! $contact->message !!}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    {{-- {{ $contacts->links('frontend.layouts.pagination') }} --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('modals')
    @parent                
@endsection

@section('scripts')
    @parent
@endsection
