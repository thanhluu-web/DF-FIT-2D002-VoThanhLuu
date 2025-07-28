<?php
  function checkDisabled($status)
  {
    if (in_array($status, ['Hoàn thành', 'Hủy'])) {
      return 'disabled';
    }
  }