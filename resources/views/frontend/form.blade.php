@php
    $lang = app()->getLocale() ?? 'en';
    $conditional_on = [];
    $colClassMap = [
        '1' => 'md:col-span-1',
        '2' => 'md:col-span-2',
        '3' => 'md:col-span-3',
        '4' => 'md:col-span-4',
        '5' => 'md:col-span-5',
        '6' => 'md:col-span-6',
        '7' => 'md:col-span-7',
        '8' => 'md:col-span-8',
        '9' => 'md:col-span-9',
        '10' => 'md:col-span-10',
        '11' => 'md:col-span-11',
        '12' => 'md:col-span-12',
    ];
    $labelClass = 'text-sm font-medium text-slate-700';
    $controlClass = 'mt-2 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-100';
@endphp

<div class="grid grid-cols-1 gap-4 md:grid-cols-12">

    @php
        $count = 1;
    @endphp
    @foreach($forms as $form)
        @php
            $fieldId = Str::slug($form->name, '_');
            $fieldLabel = $lang == 'ar' ? $form->name_ar : $form->name;
            $fieldPlaceholder = $form->placeholder ? ($lang == 'ar' ? $form->placeholder_ar : $form->placeholder) : $fieldLabel;
            $isRequired = $form->required == 'yes';
            $fieldColClass = $colClassMap[(string) ($form->col ?? '12')] ?? 'md:col-span-12';
        @endphp

        {{-- TITLE --}}
        @if($form->type == 'title')
            <div class="{{ $fieldColClass }}">
                <div class="form-group my-1 border-b border-slate-200 pb-2">
                    <h5 class="text-lg font-semibold text-slate-800">{{ $count }} . {{ $fieldLabel }}</h5>
                </div>
            </div>
            @php
                $count++;
            @endphp
        @endif


        {{-- TEXT --}}
        @if($form->type == 'text')
            <div class="{{ $fieldColClass }}">
                <div class="form-group my-1">
                    <label for="{{ $fieldId }}" class="{{ $labelClass }}">
                        {{ $fieldLabel }}
                        @if($isRequired) <span class="text-red-600">*</span> @endif
                    </label>
                    <input
                        type="text"
                        class="{{ $controlClass }}"
                        id="{{ $fieldId }}"
                        name="form_data[{{ $fieldId }}]"
                        value="{{ old('form_data.' . $fieldId) }}"
                        placeholder="{{ $fieldPlaceholder }}"
                        @if($isRequired) required @endif
                    >
                </div>
            </div>

        {{-- EMAIL --}}
        @elseif($form->type == 'email')
            <div class="{{ $fieldColClass }}">
                <div class="form-group my-1">
                    <label for="{{ $fieldId }}" class="{{ $labelClass }}">
                        {{ $fieldLabel }}
                        @if($isRequired) <span class="text-red-600">*</span> @endif
                    </label>
                    <input
                        type="email"
                        class="{{ $controlClass }}"
                        id="{{ $fieldId }}"
                        name="form_data[{{ $fieldId }}]"
                        value="{{ old('form_data.' . $fieldId) }}"
                        placeholder="{{ $fieldPlaceholder }}"
                        @if($isRequired) required @endif
                    >
                </div>
            </div>

        {{-- NUMBER --}}
        @elseif($form->type == 'number')
            <div class="{{ $fieldColClass }}">
                <div class="form-group my-1">
                    <label for="{{ $fieldId }}" class="{{ $labelClass }}">
                        {{ $fieldLabel }}
                        @if($isRequired) <span class="text-red-600">*</span> @endif
                    </label>
                    <input
                        type="number"
                        class="{{ $controlClass }}"
                        id="{{ $fieldId }}"
                        name="form_data[{{ $fieldId }}]"
                        value="{{ old('form_data.' . $fieldId) }}"
                        placeholder="{{ $fieldPlaceholder }}"
                        @if($isRequired) required @endif
                    >
                </div>
            </div>

        {{-- TEL --}}
        @elseif($form->type == 'tel')
            <div class="{{ $fieldColClass }}">
                <div class="form-group my-1">
                    <label for="{{ $fieldId }}" class="{{ $labelClass }}">
                        {{ $fieldLabel }}
                        @if($isRequired) <span class="text-red-600">*</span> @endif
                    </label>
                    <input
                        type="tel"
                        class="{{ $controlClass }}"
                        id="{{ $fieldId }}"
                        name="form_data[{{ $fieldId }}]"
                        value="{{ old('form_data.' . $fieldId) }}"
                        placeholder="{{ $fieldPlaceholder }}"
                        @if($isRequired) required @endif
                    >
                </div>
            </div>

        {{-- SELECT --}}
        @elseif($form->type == 'select')
            <div class="{{ $fieldColClass }}">
                <div class="form-group my-1">
                    <label for="{{ $fieldId }}" class="{{ $labelClass }}">
                        {{ $fieldLabel }}
                        @if($isRequired) <span class="text-red-600">*</span> @endif
                    </label>
                    <select
                        class="{{ $controlClass }}"
                        id="{{ $fieldId }}"
                        name="form_data[{{ $fieldId }}]"
                        @if($isRequired) required @endif
                    >
                        <option value="">{{ $fieldLabel }}</option>

                        @if($lang == 'ar')
                            @foreach ($form->options_ar as $option)
                                <option value="{{ $option }}">{{ $option }}</option>
                            @endforeach
                        @else
                            @foreach ($form->options as $option)
                                <option value="{{ $option }}">{{ $option }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>

        {{-- TEXTAREA --}}
        @elseif($form->type == 'textarea')
            <div class="{{ $fieldColClass }}">
                <div class="form-group my-1">
                    <label for="{{ $fieldId }}" class="{{ $labelClass }}">
                        {{ $fieldLabel }}
                        @if($isRequired) <span class="text-red-600">*</span> @endif
                    </label>
                    <textarea
                        class="{{ $controlClass }} min-h-[120px]"
                        id="{{ $fieldId }}"
                        name="form_data[{{ $fieldId }}]"
                        placeholder="{{ $fieldPlaceholder }}"
                        @if($isRequired) required @endif
                    >{{ old('form_data.' . $fieldId) }}</textarea>
                </div>
            </div>

        {{-- FILE --}}
        @elseif($form->type == 'file')
            <div class="{{ $fieldColClass }}">
                <div class="form-group my-1">
                    <label for="{{ $fieldId }}" class="{{ $labelClass }}">
                        {{ $fieldLabel }}
                        @if($isRequired) <span class="text-red-600">*</span> @endif
                    </label>
                    <input type="file"
                        class="{{ $controlClass }} file:me-3 file:rounded-md file:border-0 file:bg-blue-600 file:px-3 file:py-1.5 file:text-sm file:font-medium file:text-white hover:file:bg-blue-700"
                        id="{{ $fieldId }}"
                        name="form_file[{{ $fieldId }}][]"
                        @if($isRequired) required @endif
                    >
                </div>
            </div>

        {{-- CHECKBOX --}}
        @elseif($form->type == 'checkbox')
            <div class="{{ $fieldColClass }}">
                <div class="form-group my-1">
                    @php
                        $display = isset($form->display) ? $form->display : '';
                        $isInline = $display == 'form-check-inline';
                    @endphp

                    <div class="{{ $labelClass }}">
                        {{ $fieldLabel }}
                        @if($isRequired) <span class="text-red-600">*</span> @endif
                    </div>

                    <div class="mt-2 {{ $isInline ? 'flex flex-wrap gap-x-6 gap-y-2' : 'space-y-2' }}">
                    @foreach($lang == 'ar' ? $form->options_ar : $form->options as $option)
                        @php $optionId = $fieldId . '_' . Str::slug($option, '_'); @endphp
                        <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                            <input type="checkbox"
                                class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500"
                                id="{{ $optionId }}"
                                name="form_checkbox[{{ $fieldId }}][]"
                                value="{{ $option }}"
                            >
                            <span>{{ $option }}</span>
                        </label>
                    @endforeach
                    </div>
                </div>
            </div>

        {{-- RADIO --}}
        @elseif($form->type == 'radio')
            <div class="{{ $fieldColClass }}">
                <div class="form-group my-1">
                    @php
                        $display = isset($form->display) ? $form->display : '';
                        $isInline = $display == 'form-check-inline';
                    @endphp

                    <div class="{{ $labelClass }}">
                        {{ $fieldLabel }}
                        @if($isRequired) <span class="text-red-600">*</span> @endif
                    </div>

                    <div class="mt-2 {{ $isInline ? 'flex flex-wrap gap-x-6 gap-y-2' : 'space-y-2' }}">
                    @foreach($lang=='ar' ? $form->options_ar : $form->options as $option)
                        @php $optionId = $fieldId . '_' . Str::slug($option, '_'); @endphp
                        <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                            <input type="radio"
                                class="h-4 w-4 border-slate-300 text-blue-600 focus:ring-blue-500"
                                id="{{ $optionId }}"
                                name="form_radio[{{ $fieldId }}]"
                                value="{{ $option }}"
                                @if($isRequired) required @endif
                            >
                            <span>{{ $option }}</span>
                        </label>
                    @endforeach
                    </div>
                </div>
            </div>

        {{-- DATE / TIME --}}
        @elseif(in_array($form->type, ['date','datetime','time']))
            <div class="{{ $fieldColClass }}">
                <div class="form-group my-1">
                    <label for="{{ $fieldId }}" class="{{ $labelClass }}">
                        {{ $fieldLabel }}
                        @if($isRequired) <span class="text-red-600">*</span> @endif
                    </label>
                    <input
                        type="{{ $form->type }}"
                        class="{{ $controlClass }}"
                        id="{{ $fieldId }}"
                        name="form_data[{{ $fieldId }}]"
                        value="{{ old('form_data.' . $fieldId) }}"
                        placeholder="{{ $fieldPlaceholder }}"
                        @if($isRequired) required @endif
                    >
                </div>
            </div>
        @endif
    @endforeach
</div>
