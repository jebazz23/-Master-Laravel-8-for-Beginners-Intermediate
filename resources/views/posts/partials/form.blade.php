<div class="form-group">
    <label for="title">Title</label>
    <input type="text" name="title" class="form-control" id="title"
        value="{{ old('title', optional($post ?? null)->title) }}">
</div>
@error('title')
    {{-- special 'message' variable --}}
    <div class="alert alert-danger">{{ $message }}</div>
@enderror

<div class="form-group">
    <label for="content">Content</label>
    <textarea name="content" class="form-control" id="content">{{ old('content', optional($post ?? null)->content) }}</textarea>
</div>


    <label for="thumbnail">Thumbnail</label>
    <input type="file" name="thumbnail" class="form-control-file" />


<x-errors></x-errors>
