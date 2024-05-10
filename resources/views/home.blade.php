@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center my-3">
            <div class="col-md-8">
                <button class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#addBoard">Create Boards</button>
            </div>
            <div class="col-md-8 my-3">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Your board</h2>
                        <ul class="list-group">
                            @foreach($createdGroups as $group)
                               <a href="{{ route ('BoardGroup' , $group ->id)}}" class=" text-decoration-none "> <li class="list-group-item">{{ $group->name }}</li></a>
                            @endforeach
                        </ul>
                    </div>
                </div>
            
                <div class="card mt-4">
                    <div class="card-body">
                        <h2 class="card-title">Board you are a member of</h2>
                        <ul class="list-group">
                            @foreach($joinedGroups as $group)
                                <a href="{{ route ('BoardGroup' , $group ->id)}}"  class=" text-decoration-none "><li class="list-group-item">{{ $group->name }}</li></a>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            
            
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="addBoard" tabindex="-1" aria-labelledby="addBoardLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBoardLabel">Add Board</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="name">Name</label>
                        <input type="text" class=" form-control " name="name" id="name">
                    </div>
                    <div class="mb-2">
                        <label for="avatar">Member</label>
                        <select multiple name="member[]" id="members" class=" form-control " style="min-height: 250px">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="confirmAdd">Thêm mới </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="module">
        let confirmAdd = document.querySelector('#confirmAdd');
        let name = document.querySelector('#name');
        let members = document.querySelector("#members");
        function refresh() {
                name.value = "",
                members.value=""
            }
        confirmAdd.addEventListener('click', function() {
            let selectedMembers = [];
            let selectedOptions = members.selectedOptions;
            for (let i = 0; i < selectedOptions.length; i++) {
                selectedMembers.push(selectedOptions[i].value);
            }
            let data = {
                name: name.value,
                members: selectedMembers
            };
           
            axios.post(" {{ route('addBoard') }}", data)
                    .then(res => {
                        let btnClose = document.querySelector("#addBoard .btn-secondary")
                        btnClose.click();
                        refresh();
                   })
        });
        Echo.channel('board')
            .listen('BoardCreated', (event) => {
          //  console.log(event);

    });
    </script>
@endsection
