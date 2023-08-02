import React from 'react'
import { Doughnut } from 'react-chartjs-2'

const data = {
  labels: ['Puntaje'],
  datasets: [
    {
      label: '# of Votes',
      data: [70, 30],
      backgroundColor: [
        'rgba(0, 189, 0, 0.6)',
        'rgba(100, 100, 100, 0.3)',
      ],
      borderColor: [
        'rgba(0, 189, 0, 0.6)',
        'rgba(100, 100, 100, 0.7)',
      ],
      borderWidth: 1,
    },
  ],
}

const DoughnutChart = () => (
  <>
    <div className='header'>
      <h1 className='title'>Doughnut Chart</h1>
    </div>
    <Doughnut data={data} />
  </>
)

export default DoughnutChart
