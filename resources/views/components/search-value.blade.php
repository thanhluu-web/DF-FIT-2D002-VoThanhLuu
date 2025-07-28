      {{-- Tìm kiếm  --}}
        <form method="GET" action="{{ route($routeName) }}" class="row g-2 align-items-center mb-3">
          <div class="col-auto">
             <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control" placeholder="Nhập từ khóa">
          </div>

          <div class="col-auto">
              <select name="search_column" class="form-select" required>
                  <option value="">-- Chọn cột --</option>

                  @foreach ($columns as $column => $label)
                    @if (!in_array($column,['stt','image','created_at','status']))
                       <option value="{{$column}}" {{ $searchColumn == $column ? 'selected' : '' }}>{{$label}}</option>
                    @endif
                     
                  @endforeach
              </select>
          </div>

          <div class="col-auto">
              <button type="submit" class="btn btn-primary">
                  <i class="bi bi-search"></i> Tìm kiếm
              </button>
          </div>
      </form>

        @if ($keyword !== '')
          @if ($dataSeached->count())
              <p>Đã tìm thấy {{ $dataSeached->total() }} kết quả</p>
          @else
              <p class="dangder">Không tìm thấy kết quả phù hợp</p>
          @endif
      @endif