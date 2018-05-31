//Not sure why these don't work, but we don't seem to need them...
//import React from 'react';
//import ReactDOM from 'react-dom';
import { Chart } from 'react-google-charts';

//This method starts everything and is called at the very bottom of the file
function Init()
{
    //Initialization stuff
    ReactDOM.render(
        <TimeTheMarketGame />, 
        document.getElementById("root")
    );

    console.log("Rendered <TimeTheMarketGame />")

    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(initChart);

}


class TimeTheMarketGame extends React.Component
{
    constructor()
    {
        super();

        this.state = {
            chart: null,
            chartData: [['Week', 'VFINX', 'Your Investment']],
            options: null,
            currentWeek: 0,
            lastWeek: 0,
            spanWeeks: 520, //10 years, 52 weeks
            myInvestment: 5.0,
            vfinxShares: 0,
            myShares: 0,
            startingInvestment: 10000.0
        }
    }

    initChart() 
    {
        const numWeeks = vfinx.length;

        //Pick a random starting between 0 and the last week minus the span
        this.setState
        ({
            currentWeek: Math.floor(Math.random() * (numWeeks - this.state.spanWeeks)),
            lastWeek: this.state.currentWeek + this.state.spanWeeks,
            vfinxShares: this.state.startingInvestment / vfinx[this.state.currentWeek][1],
            myShares: this.state.startingInvestment / vfinx[this.state.currentWeek][1]
        });

        this.pushNextDataPoint();

        this.state.options = {
          title: 'Beat The Market',
          hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}, minValue: this.state.currentWeek, maxValue: this.state.lastWeek},
          vAxis: {title: 'Percent Gain', minValue: 0}
        };

        console.log("Attemping to draw chart");
        console.log(google);
        this.state.chart = new google.visualization.AreaChart(this.refs.chart);
        this.state.chart.draw(google.visualization.arrayToDataTable(chartData), this.state.options);
        console.log("Drew chart");

        setTimeout(this.updateChart, 100);
    }

    pushNextDataPoint()
    {
        var vfinxPercentGain = 100 * (vfinx[this.state.currentWeek][1] * this.state.vfinxShares / this.state.startingInvestment - 1);
        var myPercentGain = 100 * (vfinx[this.state.currentWeek][1] * this.state.myShares / this.state.startingInvestment - 1);


        var nextDataPoint = [
            this.state.currentWeek,
            this.state.vfinxPercentGain,
            this.state.myPercentGain
        ];

        this.state.chartData.push(nextDataPoint);

        this.state.currentWeek++;
    }

    updateChart()
    {
        pushNextDataPoint();

        chart.draw(google.visualization.arrayToDataTable(chartData), options);

        if(currentWeek < lastWeek)
        {
            setTimeout(updateChart, 100);
        }
    }    

    //hook runs after component output has been rendered
    componentDidMount() 
    {
        //this.initChart();
    }    

    render() {

        // var divStyle = {
        //     width: '100%',
        //     height: '500px'
        // };

        return (
            <Chart
                chartType="ScatterChart"
                data={[['Age', 'Weight'], [8, 12], [4, 5.5]]}
                options={{}}
                graph_id="ScatterChart"
                width="100%"
                height="400px"
                legend_toggle
            />
        )
    }
}




// class Hello extends React.Component {
    
//     constructor(){
//         super();
//         this.state = {
//             message: "my friend (from state)!"
//         };
//         this.updateMessage = this.updateMessage.bind(this);
//     }
//     updateMessage() {
//         this.setState({
//             message: "my friend (from changed state)!"
//         });
//     }
//     render() {
//          return (
//            <div>
//              <h1>Hello {this.state.message}!</h1>
//              <button onClick={this.updateMessage}>Click me!</button>
//            </div>   
//         )
//     }
// }

//Keep this at the bottom of the file
Init();



 