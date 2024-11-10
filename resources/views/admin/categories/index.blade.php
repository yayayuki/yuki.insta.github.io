@extends('layouts.app')

@section('title', 'Admin: Categories')

@section('content')
    <form action="{{ route('admin.categories.store')}}" method="post">
        @csrf

        <div class="row gx-2 mb-4">
            <div class="col-4">
                <input type="text" name="name" id="name" class="col-4 form-control" placeholder="Add a category..." value="{{ old('name') }}" autofocus>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i> Add
                </button>
            </div>
            @error('name')
            <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>
    </form>

    <div class="row">
        <div class="col-7">
            <table class="table table-hover align-middle bg-white border table-sm text-center">
                <thead class="small table-warning">
                    <tr>
                        <th>#</th>
                        <th>NAME</th>
                        <th>COUNT</th>
                        <th>LAST UPDATED</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($all_categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td class="fw-bold">{{ $category->name }}</td>
                            <td>{{ $category->categoryPost->count() }}</td>
                            <td>{{ $category->updated_at }}</td>
                            <td>
                                <button title="Edit" class="btn btn-outline-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#edit-category-{{ $category->id }}"><i class="fa-solid fa-pen"></i></button>
                                <button title="Delete" class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-trash-can" data-bs-toggle="modal" data-bs-target="#delete-category-{{ $category->id }}"></i></button>
                            </td>
                        </tr>
                        {{-- Include modal --}}
                        @include('admin.categories.modals.action')
                    @endforeach
                    <tr>
                        <td></td>
                        <td class="fw-bold">
                            Uncategorized
                            <p class="xsmall mb-0 text-secondary fw-normal">Hidden posts are not included.</p>
                        </td>
                        <td>{{ $uncategorized_count }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection