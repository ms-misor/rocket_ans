<!-- Modal -->
<div class="modal fade" id="payment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Subscription Payment Method</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <form action="{{ route('payment-methods.store') }}" method="POST">
                @csrf
                <div class="modal-body row">
                    <div class="mt-3 row">
                        <label class="col-sm-3 col-form-label fw-semi-bold">Title</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="title" type="text"  id="example-date-input" required placeholder="Payment Methods Name">
                            @if($errors->has('title'))
                               <span class="text-danger error">{{ $errors->first('title') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mt-3 row">
                        <label for="status"  class="col-sm-3 col-form-label fw-semi-bold">Is Active</label>
                        <div class="col-sm-8">
                            <div class="form-check mt-2">
                                {{-- <label class="form-check-label mt-1" for="status">Is Active</label> --}}
                                <input type="checkbox" name="status" id="status" value="1" class="form-check-input">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
      </div>
    </div>
  </div>
