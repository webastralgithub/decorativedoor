@extends('admin.layouts.app')

@section('content')

<div class="mx-4 content-p-mobile">
    <div class="page-header-tp">
        <h3>Add Signature</h3>

        <div class="top-bntspg-hdr">
            <a href="{{ route('orders.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
        </div>
    </div>
    @if(\Session::has('error'))
    <div>
        <li class="alert alert-danger">{!! \Session::get('error') !!}</li>
    </div>
    @endif

    @if(\Session::has('success'))
    <div>
        <li class="alert alert-success">{!! \Session::get('success') !!}</li>
    </div>
    @endif
    <div class="body-content-new">
        <form name="form1" action="{{ route('orders.delivery_user_save') }}" method="post"
            enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mt-4">
                        <div class="card-body delivery-user-imguploads">
                            <input type="hidden" name="order_id" value="{{$order->id}}">
                            <label class="col-md-4 col-form-label text-md-end text-start">Images*</label>
                            <div class="mt-1 text-center">
                                <div class="images-preview-div"> </div>
                            </div>
                            <div class="small font-italic text-muted mb-2">
                                JPG or PNG no larger than 2 MB
                            </div>
                            <input type="file" accept="image/*" id="image" name="images[]"
                                class="form-control @error('product_images') is-invalid @enderror"
                                onchange="previewImages(this, 'div.images-preview-div')" multiple required>
                            @error('images')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <br>
            <div class="row">
                <div class="col-lg-12">
                    <label class="col-md-4 col-form-label text-md-end text-start">Signature*</label>
                    <div class="card mt-4">
                        <canvas id="signature-pad" style="border: 1px;" width="800" height="300"></canvas>
                        <input type="hidden" name="signature" id="signature" value="">
                    </div>
                </div>
            </div>
            <br>
            <div class="mb-1 row">
                <input type="button" onclick="saveSignature()" class="col-md-4 offset-md-4 btn btn-primary" value="Add">
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/signature_pad"></script>
<script>
 const signaturePad = new SignaturePad(document.getElementById('signature-pad'));

function saveSignature() {
    if (signaturePad.isEmpty()) {
        alert('Please provide a signature.');
        return false; 
    }

    const signatureData = signaturePad.toDataURL("image/png");
    document.getElementById('signature').value = signatureData;

    document.forms["form1"].submit();
}
</script>
@endsection