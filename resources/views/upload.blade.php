<!DOCTYPE html>
<html>

<head>
    <title>Upload PDF</title>
</head>

<body>
    <form action="{{ route('upload.handle') }}" method="post" enctype="multipart/form-data">
        @csrf
        <label for="file">Upload PDF:</label>
        <input type="file" name="file" id="file">
        <button type="submit">Upload</button>
    </form>
</body>

</html>
