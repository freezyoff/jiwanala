<!-- BEGIN	: Form {{$prefix}}-->
<input name="{{$prefix}}[gender]" 
	@if ($prefix == 'father')
	value="l"
	@elseif ($prefix == 'mother')
	value="p"
	@endif
	type="hidden" />
	
<div class="w3-row">
	<div class="w3-col s12 m6 l6">
		<div class="input-group @error($prefix.'.kk') error @enderror">
			<label><i class="far fa-address-card fa-fw"></i></label>
			<input name="{{$prefix}}[kk]" type="text" value="{{old($prefix.'.kk','')}}" 
				placeholder="{{trans($trans.'.hints.kk')}}" 
				class="w3-input"/>
		</div>
		@error($prefix.'.kk')
		<label class="w3-text-red padding-left-8">{{$errors->first($prefix.'.kk')}}</label>
		@else
		<label>&nbsp;</label>
		@enderror
	</div>
	<div class="w3-col s12 m6 l6 padding-left-8 padding-none-small">
		<div class="input-group @error($prefix.'.nik') error @enderror">
			<label><i class="far fa-address-card fa-fw"></i></label>
			<input name="{{$prefix}}[nik]" type="text" value="{{old($prefix.'.nik','')}}" 
				placeholder="{{trans($trans.'.hints.nik')}}" 
				class="w3-input"/>
		</div>
		@error($prefix.'.nik')
		<label class="w3-text-red padding-left-8">{{$errors->first($prefix.'.nik')}}</label>
		@else
		<label>&nbsp;</label>
		@enderror
	</div>
</div>

<div class="w3-row">
	<div class="w3-col @if ($prefix=='guardian') s12 m6 l6 @else s12 @endif">
		<div class="input-group @error($prefix.'.name_full') error @enderror">
			<label><i class="far fa-address-card fa-fw"></i></label>
			<input name="{{$prefix}}[name_full]" type="text" value="{{ old($prefix.'.name_full','') }}" 
				placeholder="{{str_replace(':attr', trans($trans.'.'.$prefix), trans($trans.'.hints.name'))}}" 
				class="w3-input"/>
		</div>
		@error($prefix.'.name_full')
		<label class="w3-text-red padding-left-8">{{$errors->first($prefix.'.name_full')}}</label>
		@else
		<label>&nbsp;</label>
		@enderror
	</div>
	
	@if ($prefix == 'guardian')
		<div class="w3-col s12 m6 l6 padding-left-8 padding-none-small">
			<div class="input-group @error($prefix.'.gender') error @enderror">
				<label><i class="far fa-address-card fa-fw"></i></label>
				<?php 
					$opts = [
						'name'=>			$prefix.'[gender]',
						'dropdown'=>		['layouts.dashboard.components.select_gender_items',[]],
						'modalTitle'=>		trans($trans.'.hints.gender'),
						'placeholder'=>		trans($trans.'.hints.gender'),
						'value' =>			old($prefix.'.gender')
					];
				?>
				@include('layouts.dashboard.components.select',$opts)
			</div>
			@error($prefix.'.gender')
			<label class="w3-text-red padding-left-8">{{$errors->first($prefix.'.gender')}}</label>
			@else
			<label>&nbsp;</label>
			@enderror
		</div>
	@endif
</div>

<div class="w3-row">
	<div class="w3-col s12 m4 l4">
		<div class="input-group @error($prefix.'.birth_place') error @enderror">
			<label><i class="far fa-address-card fa-fw"></i></label>
			<input name="{{$prefix}}[birth_place]" type="text" value="{{old($prefix.'.birth_place','')}}" 
				placeholder="{{trans($trans.'.hints.birth_place')}}" 
				class="w3-input"/>
		</div>
		@error($prefix.'.birth_place')
		<label class="w3-text-red padding-left-8">{{$errors->first($prefix.'.birth_place')}}</label>
		@else
		<label>&nbsp;</label>
		@enderror
	</div>

	<div class="w3-col s12 m8 l8 padding-left-8 padding-none-small">
		<div class="input-group @error($prefix.'.birth_date') error @enderror">
			<label><i class="far fa-address-card fa-fw"></i></label>
			<?php 
				$opt = [
					'name'=>$prefix.'[birth_date]',
					'value'=>old($prefix.'.birth_date'),
					'placeholder'=>trans($trans.'.hints.birth_date'),
					'modalTitle'=>trans($trans.'.hints.birth_date'),
				];
			?>
			@include('layouts.dashboard.components.datepicker', $opt)
		</div>
		@error($prefix.'.birth_date')
		<label class="w3-text-red padding-left-8">{{$errors->first($prefix.'.birth_date')}}</label>
		@else
		<label>&nbsp;</label>
		@enderror
	</div>
</div>

<div class="w3-row">
	@foreach([0,1] as $index)
	<?php $isFirst = $index==0; ?>
	<div class="w3-col s12 m12 l12">
		<div class="input-group @error('$prefix.address.'.$index) error @enderror">
			<label><i class="far fa-address-card fa-fw"></i></label>
			<input name="{{$prefix}}[address][{{$index}}]" 
				value="{{old($prefix.'.address.'.$index)}}" 
				placeholder="{{trans($trans.'.hints.'. ($isFirst? 'address' : 'work_address'))}}"
				class="w3-input" type="text" />
		</div>
		@error($prefix.'.address.'.$index)
		<label class="w3-text-red padding-left-8">{{$errors->first($prefix.'.address.'.$index)}}</label>
		@else
		<label>&nbsp;</label>
		@enderror
	</div>
	<div class="w3-col s12 m2 l2">
		<div class="input-group @error($prefix.'.address.'.$index) error @enderror">
			<label><i class="far fa-address-card fa-fw"></i></label>
			<input name="{{$prefix}}[neighbourhood][{{$index}}]" 
				value="{{old($prefix.'.neighbourhood.'.$index)}}" 
				placeholder="{{trans($trans.'.hints.neighbourhood')}}"
				class="w3-input" type="text" />
		</div>
		@error($prefix.'.neighbourhood.'.$index)
		<label class="w3-text-red padding-left-8">{{$errors->first($prefix.'.neighbourhood.'.$index)}}</label>
		@else
		<label>&nbsp;</label>
		@enderror
	</div>
	<div class="w3-col s12 m2 l2 padding-left-8 padding-none-small">
		<div class="input-group @error($prefix.'.hamlet.'.$index) error @enderror">
			<label><i class="far fa-address-card fa-fw"></i></label>
			<input name="{{$prefix}}[hamlet][{{$index}}]" 
				value="{{old($prefix.'.hamlet.'.$index)}}" 
				placeholder="{{trans($trans.'.hints.hamlet')}}"
				class="w3-input" type="text" />
		</div>
		@error($prefix.'.hamlet.'.$index)
		<label class="w3-text-red padding-left-8">{{$errors->first($prefix.'.hamlet.'.$index)}}</label>
		@else
		<label>&nbsp;</label>
		@enderror
	</div>
	<div class="w3-col s12 m4 l4 padding-left-8 padding-none-small">
		<div class="input-group @error($prefix.'.urban.'.$index) error @enderror">
			<label><i class="far fa-address-card fa-fw"></i></label>
			<input name="{{$prefix}}[urban][{{$index}}]" 
				value="{{old($prefix.'.urban.'.$index)}}" 
				placeholder="{{trans($trans.'.hints.urban')}}"
				class="w3-input" type="text" />
		</div>
		@error($prefix.'.urban.'.$index)
		<label class="w3-text-red padding-left-8">{{$errors->first($prefix.'.urban.'.$index)}}</label>
		@else
		<label>&nbsp;</label>
		@enderror
	</div>
	<div class="w3-col s12 m4 l4 padding-left-8 padding-none-small">
		<div class="input-group @error($prefix.'.subdistrict.'.$index) error @enderror">
			<label><i class="far fa-address-card fa-fw"></i></label>
			<input name="{{$prefix}}[subdistrict][{{$index}}]" 
				value="{{old($prefix.'.subdistrict.'.$index)}}" 
				placeholder="{{trans($trans.'.hints.subdistrict')}}"
				class="w3-input" type="text" />
		</div>
		@error($prefix.'.subdistrict.'.$index)
		<label class="w3-text-red padding-left-8">{{$errors->first($prefix.'.subdistrict.'.$index)}}</label>
		@else
		<label>&nbsp;</label>
		@enderror
	</div>
	<div class="w3-col s12 m4 l4">
		<div class="input-group @error($prefix.'.district.'.$index) error @enderror">
			<label><i class="far fa-address-card fa-fw"></i></label>
			<input name="{{$prefix}}[district][{{$index}}]" 
				value="{{old($prefix.'.district.'.$index)}}" 
				placeholder="{{trans($trans.'.hints.district')}}"
				class="w3-input" type="text" />
		</div>
		@error($prefix.'.district.'.$index)
		<label class="w3-text-red padding-left-8">{{$errors->first($prefix.'.district.'.$index)}}</label>
		@else
		<label>&nbsp;</label>
		@enderror
	</div>
	<div class="w3-col s12 m4 l4 padding-left-8 padding-none-small">
		<div class="input-group @error($prefix.'.province.'.$index) error @enderror">
			<label><i class="far fa-address-card fa-fw"></i></label>
			<input name="{{$prefix}}[province][{{$index}}]" 
				value="{{old($prefix.'.province.'.$index)}}" 
				placeholder="{{trans($trans.'.hints.province')}}"
				class="w3-input" type="text" />
		</div>
		@error($prefix.'.province.'.$index)
		<label class="w3-text-red padding-left-8">{{$errors->first($prefix.'.province.'.$index)}}</label>
		@else
		<label>&nbsp;</label>
		@enderror
	</div>
	<div class="w3-col s12 m4 l4 padding-left-8 padding-none-small">
		<div class="input-group @error($prefix.'.postcode.'.$index) error @enderror">
			<label><i class="far fa-address-card fa-fw"></i></label>
			<input name="{{$prefix}}[postcode][{{$index}}]" 
				value="{{old($prefix.'.postcode.'.$index)}}" 
				placeholder="{{trans($trans.'.hints.postcode')}}"
				class="w3-input" type="text" />
		</div>
		@error($prefix.'.postcode.'.$index)
		<label class="w3-text-red padding-left-8">{{$errors->first($prefix.'.postcode.'.$index)}}</label>
		@else
		<label>&nbsp;</label>
		@enderror
	</div>
	@endforeach
</div>

<div class="w3-row">
	@for($i=0;$i<count(old($prefix.'.email',[0,1]));$i++)
		<div class="w3-col s12 m6 l6 @if($i>0) padding-left-8 padding-none-small @endif">
			<div class="input-group">
				<label><i class="far fa-address-card fa-fw"></i></label>
				<input name="{{$prefix}}[email][{{$i}}]" type="text" value="{{old($prefix.'.email.'.$i,'')}}" 
					placeholder="{{trans($trans.'.hints.email')}}" 
					class="w3-input" />
			</div>
			@error($prefix.'.email.'.$i)
			<label class="w3-text-red padding-left-8">{{$errors->first($prefix.'.email.'.$i)}}</label>
			@else
			<label>&nbsp;</label>
			@enderror
		</div>
	@endfor
</div>

<div class="w3-row">
	@for($i=0;$i<count(old($prefix.'.phone',[0,1]));$i++)
		<div class="w3-col s12 m6 l6 @if($i>0) padding-left-8 padding-none-small @endif">
			<div class="input-group">
				<label>+62</label>
				<input name="{{$prefix}}[phone][{{$i}}]" type="text" value="{{old($prefix.'.phone.'.$i,'')}}" 
					placeholder="{{trans($trans.'.hints.phone')}}" 
					class="w3-input" />
			</div>
			@error($prefix.'.phone.'.$i)
			<label class="w3-text-red padding-left-8">{{$errors->first($prefix.'.phone.'.$i)}}</label>
			@else
			<label>&nbsp;</label>
			@enderror
		</div>
	@endfor
</div>

<!-- END: Form -->