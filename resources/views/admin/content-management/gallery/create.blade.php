@extends('layouts.admin-app')

@section('title', 'Admin | GALLERY | ADD IMAGES')
@section('breadcrumb_item_1', 'Gallery')
@section('breadcrumb_item_2', 'Create')

@section('content')

<div class="container-fluid">

    <h4 class="text-left mb-3">ADD IMAGES</h4>
    <form action="{{ route('admin.galleries.store') }}" data-action="{{ route('admin.galleries.store') }}" method="POST" class="add-image-form" enctype="multipart/form-data">

        <div class="row" id="card-container">
            <!-- Image Upload Card -->
            <div class="col-md-4 mb-4">

                <div class="card">
                    <div class="card-body">
                        @csrf
                        <div class="form-group">
                            <label for="image">Image Upload:</label>
                            <input type="file" name="inputs[0][image_path]" class="form-control-file" id="image0" onchange="previewImage(this, 'image-preview1')" multiple>
                            <img id="image-preview1" src="#" alt="Preview" style="display: none; max-width: 100%; height: auto; width: 200px; height: 200px; object-fit: contain;" class="mt-2">
                        </div>
                        <div class="form-group">
                            <label for="caption">Caption</label>
                            <textarea name="inputs[0][caption]" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="categories">Categories:</label>
                            <select name="inputs[0][category_id][]" class="form-control" multiple>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>

            </div>

            <!-- Plus Icon Card -->
            <div class="col-md-4 mb-4">
                <div class="card bg-primary text-white text-center plus-icon-card" id="plus-icon-card" style="height:400px;">
                    <div class="card-body" style="display:flex; justify-content:center; align-items:center">
                        <i class="fas fa-plus fa-5x"></i>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mb-3" id="submit-form">Add Images</button>
    </form>
</div>


<script>
    function previewImage(input, previewId) {
        var preview = document.getElementById(previewId);
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    // JavaScript for adding new image upload fields
    cardId = 0;
    document.getElementById('plus-icon-card').addEventListener('click', function() {
        // Create a new card element
        var newCard = document.createElement('div');
        // var cardId = document.querySelectorAll('.col-md-4').length + 1;
        cardId++;
        console.log(cardId)
        newCard.classList.add('col-md-4', 'mb-4');
        newCard.innerHTML = `
            <div class="card">
                <div class="card-body">
                    <!-- Card content goes here -->
                    
                        <div class="form-group">
                            <label for="image">Image Upload:</label>
                            <input type="file" name="inputs[` + cardId + `][image_path]" class="form-control-file" id="image${cardId}" onchange="previewImage(this, 'image-preview${cardId}')" multiple>
                            <img id="image-preview${cardId}" src="#" alt="Preview" style="display: none; max-width: 100%; height: auto; width: 200px; height: 200px; object-fit: contain;" class="mt-2">
                        </div>
                        <div class="form-group">
                            <label for="caption">Caption</label>
                            <textarea name="inputs[` + cardId + `][caption]" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="categories">Categories:</label>
                            <select name="inputs[` + cardId + `][category_id][]" class="form-control" multiple>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    
                </div>
            </div>
        `;

        // Append the new card to the card container
        document.getElementById('card-container').insertBefore(newCard, document.getElementById('plus-icon-card').parentNode);

    });

    // document.getElementById('submit-form').addEventListener('click', function() {
    //     var forms = document.querySelectorAll('.add-image-form');
    //     forms.forEach(function(form) {
    //         form.submit();
    //     });
    // });
</script>
@endsection