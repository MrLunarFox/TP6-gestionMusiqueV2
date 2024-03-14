// Importer Chart.js
import Chart from 'chart.js';

// Fonction pour créer le diagramme
function createNationaliteChart(ctx, data) {
  // Créer une nouvelle instance de Chart
  var chart = new Chart(ctx, {
    type: 'doughnut',
    data: data,
    options: {
      title: {
        text: 'Répartition des artistes par nationalité'
      },
      legend: {
        position: 'bottom'
      },
      tooltips: {
        callbacks: {
          label: function(tooltipItem) {
            return tooltipItem.yLabel + ' artistes (' + tooltipItem.label + ')';
          }
        }
      }
    }
  });
}

// Exporter la fonction
export default createNationaliteChart;