$(document).ready(function(){

	$.ajax({
		type:'post',
		url:'/kb-backend/student-report',
		success: function(d){
			
			var ctx = document.getElementById('student').getContext('2d');

			var myChart = new Chart(ctx, {
			    type: 'line',
			    data: {
			        labels: d.months,
			        datasets: [{
			            label: 'Active',
			            data: d.active,
			            backgroundColor: [
			                'rgba(255, 99, 132, 0.2)',
			                'rgba(54, 162, 235, 0.2)',
			                'rgba(255, 206, 86, 0.2)',
			                'rgba(75, 192, 192, 0.2)',
			                'rgba(153, 102, 255, 0.2)',
			                'rgba(255, 159, 64, 0.2)'
			            ],
			            borderColor: [
			                'rgba(255, 99, 132, 1)',
			                'rgba(54, 162, 235, 1)',
			                'rgba(255, 206, 86, 1)',
			                'rgba(75, 192, 192, 1)',
			                'rgba(153, 102, 255, 1)',
			                'rgba(255, 159, 64, 1)'
			            ],
			            borderWidth: 1
			        },{
			            label: 'Discontinued',
			            data: d.in_active,
			            backgroundColor: [
			                'rgba(255, 99, 132, 0.2)',
			                'rgba(54, 162, 235, 0.2)',
			                'rgba(255, 206, 86, 0.2)',
			                'rgba(75, 192, 192, 0.2)',
			                'rgba(153, 102, 255, 0.2)',
			                'rgba(255, 159, 64, 0.2)'
			            ],
			            borderColor: [
			                'rgba(255, 99, 132, 1)',
			                'rgba(54, 162, 235, 1)',
			                'rgba(255, 206, 86, 1)',
			                'rgba(75, 192, 192, 1)',
			                'rgba(153, 102, 255, 1)',
			                'rgba(255, 159, 64, 1)'
			            ],
			            borderWidth: 1
			        }]
			    },
			});
		}
	});


	$.ajax({
		type:'post',
		url:'/kb-backend/get-card-count',
		success: function(d){
			var inquiry = document.getElementById('inquiry').getContext('2d');
			new Chart(inquiry, {
			    type: 'pie',
			    data: {
				    labels: ['Collaborations', 'Regular Batch Enquiry', 'Upcoming Workshop Enquiry'],
				    datasets: [{
				      	data: d,
				      	backgroundColor: [
				          "#DC143C",
				          "#F4A460",
				          "#2E8B57"
				        ],
				    }]
				},
				options: {
					responsive: true,
    				maintainAspectRatio: true,
    				aspectRatio:3,
				    plugins: {
				      datalabels: {
				        display: true,
				        align: 'bottom',
				        backgroundColor: '#ccc',
				        borderRadius: 1,
				        font: {
				          size: 18,
				        }
				      },
				    }
				  }
			});
		}
	});


	$.ajax({
		type:'post',
		url:'/kb-backend/invoice-report',
		success: function(d){
			var amount = document.getElementById('amount').getContext('2d');
			var myChart = new Chart(amount, {
			    type: 'line',
			    data: {
			        labels: d.months,
			        datasets: [{
			            label: 'Total Billed Amount',
			            data: d.bamount,
			            backgroundColor: [
			                'rgba(255, 99, 132, 0.2)',
			                'rgba(54, 162, 235, 0.2)',
			                'rgba(255, 206, 86, 0.2)',
			                'rgba(75, 192, 192, 0.2)',
			                'rgba(153, 102, 255, 0.2)',
			                'rgba(255, 159, 64, 0.2)'
			            ],
			            borderColor: [
			                'rgba(255, 99, 132, 1)',
			                'rgba(54, 162, 235, 1)',
			                'rgba(255, 206, 86, 1)',
			                'rgba(75, 192, 192, 1)',
			                'rgba(153, 102, 255, 1)',
			                'rgba(255, 159, 64, 1)'
			            ],
			            borderWidth: 1
			        },{
			            label: 'Total Recieved Amount',
			            data: d.ramount,
			            backgroundColor: [
			                'rgba(255, 99, 132, 0.2)',
			                'rgba(54, 162, 235, 0.2)',
			                'rgba(255, 206, 86, 0.2)',
			                'rgba(75, 192, 192, 0.2)',
			                'rgba(153, 102, 255, 0.2)',
			                'rgba(255, 159, 64, 0.2)'
			            ],
			            borderColor: [
			                'rgba(255, 99, 132, 1)',
			                'rgba(54, 162, 235, 1)',
			                'rgba(255, 206, 86, 1)',
			                'rgba(75, 192, 192, 1)',
			                'rgba(153, 102, 255, 1)',
			                'rgba(255, 159, 64, 1)'
			            ],
			            borderWidth: 1
			        }]
			    },
			});
		}
	});
});