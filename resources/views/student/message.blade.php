@extends('layout.header1')
@section('title')
Inbox || Learning Management system
@endsection

@section('content')

<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Messages</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Student</a></li>
                        <li class="breadcrumb-item active">Inbox</li>
                    </ol>
                    <button type="button" class="btn btn-info m-l-15" data-toggle="modal" data-target="#responsive-modal"><i class="icon-plus"></i> New Message</button>

                </div>
            </div>
        </div>
        <!-- sample modal content -->
        <div id="responsive-modal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>New Message</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <form method="post" enctype="multipart/form-data" action="{{ route('studentsendmessage') }}">
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="control-label">Recipient:</label>
                                <select class="form-control" name="reciever_id">
                                    <option selected disabled>Choose Recipient</option>
                                    @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->username }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Attachement:</label>
                                <input type="file" class="form-control" name="attachment">
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="control-label">Message:</label>
                                <textarea class="form-control" name="content"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Send Message</button>
                        </div>
                        <input type="hidden" name="_token" value="{{ Session::token() }}">
                    </form>
                </div>
            </div>
        </div>
        <!-- /.modal -->
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        @include('include.success')
        @include('include.warning')
        @include('include.error')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">All Messages</h4>
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Inbox</span></a> </li>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile" role="tab"><span class="hidden-sm-up"><i class="ti-location-arrow"></i></span> <span class="hidden-xs-down">Sent Message</span></a> </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabcontent-border">
                            <div class="tab-pane active table-responsive" id="home" role="tabpanel">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Sent By</th>
                                            <th>Attachment</th>
                                            <th>Message</th>
                                            <th>Date Sent</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($inbox as $inbox)
                                        <tr>
                                            <td>{{ $inbox->sender->username }}</td>
                                            <td><a href="../upload/message/{{ $inbox->attachment }}" target="_blank">{{ $inbox->attachment }}</a></td>
                                            <td>{{ $inbox->content }}</td>
                                            <td>{{ $inbox->created_at->diffForHumans() }}</td>
                                            <td><a href="#" data-toggle="modal" data-target="#delete{{ $inbox->id }}"><i class="icon-trash"></i> Delete</a></td>
                                            <!-- sample modal content -->
                                            <div id="delete{{ $inbox->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h4><strong>Confirm Deletion</strong></h4>
                                                            <p>Are you sure you want to Delete Record</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Close</button>
                                                            <a href="{{ route('deletemessage',$inbox->id) }}" class="btn btn-success waves-effect waves-light">Yes</a>
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->
                                        </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                            <div class="tab-pane table-responsive" id="profile" role="tabpanel">
                                <table class="display nowrap table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <td>Sender</td>
                                            <th>Sent To</th>
                                            <th>Attachment</th>
                                            <th>Message</th>
                                            <th>Date Sent</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sent as $sent)
                                        <tr>
                                            <td>{{ $sent->sender->username }}</td>
                                            <td>{{ $sent->reciever->username }}</td>
                                            <td><a href="../upload/message/{{ $sent->attachment }}" target="_blank">{{ $sent->attachment }}</a></td>
                                            <td>{{ $sent->content }}</td>
                                            <td>{{ $sent->created_at->diffForHumans() }}</td>
                                            <td><a href="#" data-toggle="modal" data-target="#delete{{ $sent->id }}"><i class="icon-trash"></i> Delete</a></td>
                                            <!-- sample modal content -->
                                            <div id="delete{{ $sent->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h4><strong>Confirm Deletion</strong></h4>
                                                            <p>Are you sure you want to Delete Record</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Close</button>
                                                            <a href="{{ route('deletemessage',$sent->id) }}" class="btn btn-success waves-effect waves-light">Yes</a>
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->
@endsection