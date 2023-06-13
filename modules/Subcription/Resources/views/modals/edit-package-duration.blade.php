

  <div class="modal fade" id="exampleModal{{ $duration->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Package Duration</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('package-durations.update',$duration->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="modal-body row">
                <div class="mt-3 row">
                    <label class="col-sm-3 col-form-label fw-semi-bold">Duration</label>
                    <div class="col-sm-8">
                        <select name="unit" class="form-select" disabled>
                           <option value="">Select Package Duration</option>
                           @foreach(packageDuration() as $packageDuration)
                            <option value="{{ $packageDuration->value }}" {{ $packageDuration->value == $duration->unit ? 'selected' : ''}}>{{ $packageDuration->title }}</option>
                           @endforeach
                        </select>
                        @if($errors->has('unit'))
                           <span class="text-danger error">{{ $errors->first('unit') }}</span>
                        @endif
                    </div>
                </div>
                <div class="mt-3 row">
                    <label for="status"  class="col-sm-3 col-form-label fw-semi-bold">Is Active</label>
                    <div class="col-sm-8">
                        <div class="form-check mt-2">
                            {{-- <label class="form-check-label mt-1" for="status">Is Active</label> --}}
                            <input type="checkbox" name="status" value="1" {{ $duration->status == 1 ? 'checked' : ''}}>
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