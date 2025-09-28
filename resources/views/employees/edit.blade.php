@extends('layouts.app')

@section('title', '店員編集 - CRM システム')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-user-edit"></i> 店員編集: {{ $employee->full_name }}
                    </h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('employees.update', $employee) }}">
                        @csrf
                        @method('PUT')

                        <!-- 基本情報 -->
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2"><i class="fas fa-user"></i> 基本情報</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="last_name" class="form-label">姓 <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('last_name') is-invalid @enderror"
                                           id="last_name"
                                           name="last_name"
                                           value="{{ old('last_name', $employee->last_name) }}"
                                           required>
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="first_name" class="form-label">名 <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('first_name') is-invalid @enderror"
                                           id="first_name"
                                           name="first_name"
                                           value="{{ old('first_name', $employee->first_name) }}"
                                           required>
                                    @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="last_name_kana" class="form-label">姓（カナ） <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('last_name_kana') is-invalid @enderror"
                                           id="last_name_kana"
                                           name="last_name_kana"
                                           value="{{ old('last_name_kana', $employee->last_name_kana) }}"
                                           placeholder="ヤマダ"
                                           required>
                                    @error('last_name_kana')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="first_name_kana" class="form-label">名（カナ） <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('first_name_kana') is-invalid @enderror"
                                           id="first_name_kana"
                                           name="first_name_kana"
                                           value="{{ old('first_name_kana', $employee->first_name_kana) }}"
                                           placeholder="タロウ"
                                           required>
                                    @error('first_name_kana')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- 連絡先情報 -->
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2"><i class="fas fa-address-book"></i> 連絡先情報</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">メールアドレス <span class="text-danger">*</span></label>
                                    <input type="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           id="email"
                                           name="email"
                                           value="{{ old('email', $employee->email) }}"
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">電話番号</label>
                                    <input type="text"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           id="phone"
                                           name="phone"
                                           value="{{ old('phone', $employee->phone) }}"
                                           placeholder="090-1234-5678">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">住所</label>
                                <textarea class="form-control @error('address') is-invalid @enderror"
                                          id="address"
                                          name="address"
                                          rows="3">{{ old('address', $employee->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- 雇用情報 -->
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2"><i class="fas fa-briefcase"></i> 雇用情報</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="store_id" class="form-label">配属店舗 <span class="text-danger">*</span></label>
                                    <select class="form-select @error('store_id') is-invalid @enderror"
                                            id="store_id"
                                            name="store_id"
                                            required>
                                        <option value="">選択してください</option>
                                        @foreach($stores as $store)
                                            <option value="{{ $store->id }}" {{ old('store_id', $employee->store_id) == $store->id ? 'selected' : '' }}>
                                                {{ $store->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('store_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="position" class="form-label">役職 <span class="text-danger">*</span></label>
                                    <select class="form-select @error('position') is-invalid @enderror"
                                            id="position"
                                            name="position"
                                            required>
                                        <option value="">選択してください</option>
                                        <option value="trainee" {{ old('position', $employee->position) == 'trainee' ? 'selected' : '' }}>研修生</option>
                                        <option value="staff" {{ old('position', $employee->position) == 'staff' ? 'selected' : '' }}>スタッフ</option>
                                        <option value="senior_staff" {{ old('position', $employee->position) == 'senior_staff' ? 'selected' : '' }}>主任スタッフ</option>
                                        <option value="supervisor" {{ old('position', $employee->position) == 'supervisor' ? 'selected' : '' }}>主任</option>
                                        <option value="assistant_manager" {{ old('position', $employee->position) == 'assistant_manager' ? 'selected' : '' }}>副店長</option>
                                        <option value="manager" {{ old('position', $employee->position) == 'manager' ? 'selected' : '' }}>店長</option>
                                    </select>
                                    @error('position')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="employment_type" class="form-label">雇用形態 <span class="text-danger">*</span></label>
                                    <select class="form-select @error('employment_type') is-invalid @enderror"
                                            id="employment_type"
                                            name="employment_type"
                                            required>
                                        <option value="">選択してください</option>
                                        <option value="full_time" {{ old('employment_type', $employee->employment_type) == 'full_time' ? 'selected' : '' }}>正社員</option>
                                        <option value="part_time" {{ old('employment_type', $employee->employment_type) == 'part_time' ? 'selected' : '' }}>パートタイム</option>
                                        <option value="contract" {{ old('employment_type', $employee->employment_type) == 'contract' ? 'selected' : '' }}>契約社員</option>
                                        <option value="temporary" {{ old('employment_type', $employee->employment_type) == 'temporary' ? 'selected' : '' }}>臨時雇用</option>
                                    </select>
                                    @error('employment_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="status" class="form-label">状況 <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror"
                                            id="status"
                                            name="status"
                                            required>
                                        <option value="">選択してください</option>
                                        <option value="active" {{ old('status', $employee->status) == 'active' ? 'selected' : '' }}>在職中</option>
                                        <option value="inactive" {{ old('status', $employee->status) == 'inactive' ? 'selected' : '' }}>休職中</option>
                                        <option value="on_leave" {{ old('status', $employee->status) == 'on_leave' ? 'selected' : '' }}>休暇中</option>
                                        <option value="terminated" {{ old('status', $employee->status) == 'terminated' ? 'selected' : '' }}>退職済み</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="department" class="form-label">部署</label>
                                    <input type="text"
                                           class="form-control @error('department') is-invalid @enderror"
                                           id="department"
                                           name="department"
                                           value="{{ old('department', $employee->department) }}"
                                           placeholder="営業部、販売部など">
                                    @error('department')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="hire_date" class="form-label">入社日 <span class="text-danger">*</span></label>
                                    <input type="date"
                                           class="form-control @error('hire_date') is-invalid @enderror"
                                           id="hire_date"
                                           name="hire_date"
                                           value="{{ old('hire_date', $employee->hire_date ? $employee->hire_date->format('Y-m-d') : '') }}"
                                           required>
                                    @error('hire_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- 個人情報 -->
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2"><i class="fas fa-id-card"></i> 個人情報</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="birth_date" class="form-label">生年月日</label>
                                    <input type="date"
                                           class="form-control @error('birth_date') is-invalid @enderror"
                                           id="birth_date"
                                           name="birth_date"
                                           value="{{ old('birth_date', $employee->birth_date ? $employee->birth_date->format('Y-m-d') : '') }}">
                                    @error('birth_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="termination_date" class="form-label">退職日</label>
                                    <input type="date"
                                           class="form-control @error('termination_date') is-invalid @enderror"
                                           id="termination_date"
                                           name="termination_date"
                                           value="{{ old('termination_date', $employee->termination_date ? $employee->termination_date->format('Y-m-d') : '') }}">
                                    @error('termination_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- 給与情報 -->
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2"><i class="fas fa-yen-sign"></i> 給与情報</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="salary" class="form-label">月給（円）</label>
                                    <input type="number"
                                           class="form-control @error('salary') is-invalid @enderror"
                                           id="salary"
                                           name="salary"
                                           value="{{ old('salary', $employee->salary) }}"
                                           min="0"
                                           placeholder="250000">
                                    @error('salary')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="hourly_wage" class="form-label">時給（円）</label>
                                    <input type="number"
                                           class="form-control @error('hourly_wage') is-invalid @enderror"
                                           id="hourly_wage"
                                           name="hourly_wage"
                                           value="{{ old('hourly_wage', $employee->hourly_wage) }}"
                                           min="0"
                                           placeholder="1000">
                                    @error('hourly_wage')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- 備考 -->
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2"><i class="fas fa-sticky-note"></i> 備考</h5>
                            <div class="mb-3">
                                <label for="notes" class="form-label">備考・メモ</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror"
                                          id="notes"
                                          name="notes"
                                          rows="4"
                                          placeholder="特記事項やメモを入力してください">{{ old('notes', $employee->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('employees.show', $employee) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> 戻る
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> 更新
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection