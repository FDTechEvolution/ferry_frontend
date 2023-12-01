<div class="modal fade" id="extra-services" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="extraServices" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">

			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabelMd">Extra Services</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<div class="modal-body">
                <div class="row extra-meal px-3 mb-5" id="extra-meal">
                    @foreach($addons['meals'] as $key => $meal)
                        <div class="col-12 mb-3 pb-2 border-bottom">
                            <div class="row">
                                <div class="col-1 d-flex justify-content-center align-items-center">
                                    <img src="{{$icon_url}}/icon/meal/icon/{{$meal['image_icon']}}" width="80" id="extra-meal-img-{{ $key }}">
                                </div>
                                <div class="col-6">
                                    <h6 class="mb-1" id="extra-meal-name-{{ $key }}">{{ $meal['name'] }}</h6>
                                    <p class="mb-0">{{ $meal['description'] }}</p>
                                </div>
                                <div class="col-2 d-flex justify-content-center align-items-center">
                                    <span class="extra-meal-amount-{{ $key }} me-2">{{ number_format($meal['amount']) }}</span> THB
                                </div>
                                <div class="col-3 d-flex justify-content-center align-items-center">
                                    <button type="button" class="btn btn-primary rounded-circle btn-sm p-3" onClick="dec('meal', '{{ $key }}')"><i class="fi fi-minus smaller"></i></button>
                                    <input type="number" name="meal_qty[]" id="extra-meal-index-{{ $key }}" class="form-control form-control-xs text-center mx-2 border-0" value="0" readonly>
                                    <input type="hidden" name="meal_id[]" value="{{ $meal['id'] }}">
                                    <button type="button" class="btn btn-primary rounded-circle btn-sm p-3" onClick="inc('meal', '{{ $key }}')"><i class="fi fi-plus smaller"></i></button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-sm btn-primary">
					<i class="fi fi-check"></i>
					Update
				</button>
				<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">
					<i class="fi fi-close"></i>
					Cancel
				</button>
			</div>

		</div>
	</div>
</div>