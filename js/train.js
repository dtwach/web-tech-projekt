function set_add(id, name) {
    $(document).ready(function () {

      var table = document.getElementById(id);
      var row = table.insertRow(table.rows.length);
      var prev_row = table.rows[table.rows.length-1];

  
      row.innerHTML = '<input type="hidden" name="'+ id + '.inckex_' + (table.rows.length - 1)+'"/input>';

      var cell = row.insertCell(0);
      cell.innerHTML = 'Satz ' + (table.rows.length - 1);

      cell = row.insertCell(1);
      cell.innerHTML = '<input type="number" name="'+ name +'_rep_'+  (table.rows.length - 1) +'"/input>';

      cell = row.insertCell(2);
      cell.innerHTML = '<input type="number" name="'+ name +'_weight_'+  (table.rows.length - 1) +'" step="0.001"/input>';

      cell = row.insertCell(3);
      cell.innerHTML = '<input type="text" name="'+ name +'_type_'+  (table.rows.length - 1) +'" value="Standard"/input>';
      
      cell = row.insertCell(4);
      cell.innerHTML = '<input type="text" name="'+ name +'_comment_'+  (table.rows.length - 1) +'"/input>';
      
    });
  }
  