// https://pg-happy.jp/javascript-table.html
// table生成後に実行する
let table = document.getElementById("calendar-table");

for(let i=0; i<table.rows.length; i++){
  for(let j=0; j<table.rows[i].cells.length; j++){
    table.rows[i].cells[j].id = i + "-" + j;  // e.target.id
    table.rows[i].cells[j].onclick = clicked;
  }
}

function clicked(e){
  let currentMonth = document.getElementById("current-month");
  location.href ="?ym=" + currentMonth.innerText + "&d=" + e.target.innerText;
}
