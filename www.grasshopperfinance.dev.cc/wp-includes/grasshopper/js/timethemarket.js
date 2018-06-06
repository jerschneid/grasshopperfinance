//Not sure why these don't work, but we don't seem to need them...
//import React from 'react';
//import ReactDOM from 'react-dom';

var theGame;

//This method starts everything and is called at the very bottom of the file
function Init()
{

    //Initialization stuff
    // ReactDOM.render(
    //     theGame, 
    //     document.getElementById("root")
    // );

    ReactDOM.render(<TimeTheMarketGame ref={(theGame) => {window.theGame = theGame}} />, document.getElementById("root"));

    console.log("Rendered <TimeTheMarketGame />")

    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(initChart);

}


//Methods

var chart = null;
var options = null;
var chartData = null;
var currentWeek = 0;
var firstWeek = 0;
var lastWeek = 0;
const spanWeeks = 520; //10 years, 52 weeks
var vfinxShares = 0;
var myShares = 0;
var myCash = 0;
var interestRate = 0.01;
const startingInvestment = 10000.0;
var timeIntervalInMilliSeconds = 75;
const timeIntervalSpeedChange = 50;
const weeksPerDataPoint = 1;
var rideItOut = false;
var myTotalValue;
var vfinxTotalValue;

function initChart() 
{
    chartData = [
      ['Week', 'Buy and Hold', 'Your Investment'],
    ];

    const numWeeks = vfinx.length;

    //Pick a random starting between 0 and the last week minus the span
    firstWeek = currentWeek = Math.floor(Math.random() * (numWeeks - spanWeeks));
    lastWeek = currentWeek + spanWeeks;

    vfinxShares = myShares = startingInvestment / vfinx[currentWeek][1];

    pushNextDataPoint();

    options = {
        'chartArea': {left: 55, top: 5, width: '88%', height: '90%'},
        'legend': {'position': 'none'},
        hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}, minValue: 0, maxValue: spanWeeks / 52.0},
        vAxis: {title: 'Percent Gain', minValue: -0.1, maxValue: 0.1, format: 'percent'},
    };

    console.log("Attemping to draw chart");
    chart = new google.visualization.AreaChart(document.getElementById('timeTheMarketChart'));
    chart.draw(google.visualization.arrayToDataTable(chartData), options);
    console.log("Drew chart");
}

function pushNextDataPoint()
{
    //Add one week of interest at 1% 
    myCash = myCash + myCash * interestRate * weeksPerDataPoint         / 52.0;

    myTotalValue = myCash + vfinx[currentWeek][1] * myShares;
    vfinxTotalValue =  vfinx[currentWeek][1] * vfinxShares;

    var vfinxPercentGain = (vfinxTotalValue / startingInvestment - 1);
    var myPercentGain = (myTotalValue / startingInvestment - 1);

    var year = (currentWeek - firstWeek) / 52.0;

    var nextDataPoint = [
        year,
        vfinxPercentGain,
        myPercentGain
    ];

    chartData.push(nextDataPoint);
    theGame.updateScore();

    currentWeek += weeksPerDataPoint;
}

function updateChart()
{
    pushNextDataPoint();

    chart.draw(google.visualization.arrayToDataTable(chartData), options);

    if(currentWeek < lastWeek)
    {
        setTimeout(updateChart, timeIntervalInMilliSeconds);
    }
    else
    {
        console.log('Calling theGame.endGame()');
        console.log(theGame);
        theGame.endGame();
    }
}


Number.prototype.formatMoney = function(c, d, t){
    var n = this, 
    c = isNaN(c = Math.abs(c)) ? 2 : c, 
    d = d == undefined ? "." : d, 
    t = t == undefined ? "," : t, 
    s = n < 0 ? "-" : "", 
    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))), 
    j = (j = i.length) > 3 ? j % 3 : 0;
   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
 };

class TimeTheMarketGame extends React.Component
{
    constructor(){
        super();

        this.state = {
            buttonText: "Start!",
            holding: true,
            gameStarted: false,
            showResults: true,
            buySellButtonClassName: "btn btn-primary",
            myValue: startingInvestment,
            vfinxValue: startingInvestment,
            didBeatTheMarket: null
        }

        this.buySellClick = this.buySellClick.bind(this);
        this.resetClick = this.resetClick.bind(this);
        this.goFaster = this.goFaster.bind(this);
        this.goSlower = this.goSlower.bind(this);
    }

    formatDate(date)
    {
        var options = { year: 'numeric', month: 'long', day: 'numeric' };
        return new Date(date).toLocaleDateString("en-US", options);
    }    

    goFaster()
    {
        if(timeIntervalInMilliSeconds > timeIntervalSpeedChange)
        {
            timeIntervalInMilliSeconds -= timeIntervalSpeedChange;
        }
    } 

    goSlower()
    {
        timeIntervalInMilliSeconds += timeIntervalSpeedChange;
    }

    startTheGame()
    {

        this.state.gameStarted = true;

        this.setState({
            buttonText: "Sell!",
            buySellButtonClassName: "btn btn-danger"
        });

        setTimeout(updateChart, timeIntervalInMilliSeconds);
    }

    updateScore()
    {
            this.setState({
                myValue: myTotalValue,
                vfinxValue: vfinxTotalValue
            });
    }

    endGame()
    {
        var message = "You DID NOT beat the market!";
        var didBeatTheMarket = false;

        if(myCash + vfinx[lastWeek][1] * myShares > vfinx[lastWeek][1] * vfinxShares)
        {
            message = "You BEAT the market!"
            didBeatTheMarket = true;
        }

        this.setState({
            showResults: true,
            startDate: this.formatDate(vfinx[firstWeek][0]),
            endDate: this.formatDate(vfinx[lastWeek][0]),
            beatTheMarketMessage: message,
            didBeatTheMarket: didBeatTheMarket
        });

        //Scroll to the end game scoreboard
        var elmnt = this.refs.game;
        elmnt.scrollIntoView();
    }

    buySellClick() 
    {
        if(!this.state.gameStarted)
        {
            this.startTheGame();
            return;
        }

        this.state.holding = !this.state.holding;

        var newText;
        var newClass;

        //We just clicked buy
        if(this.state.holding)
        {
            //Convert cash to shares
            myShares = myCash / vfinx[currentWeek][1]
            myCash = 0;
            newText = "Sell!";
            newClass = "btn btn-danger";
        }
        else
        {
            //Convert shares to cash
            myCash = myShares * vfinx[currentWeek][1];
            myShares = 0;
            newText = "Buy!";
            newClass = "btn btn-success";
        }

        console.log(newText);

        this.setState({
            buttonText: newText,
            buySellButtonClassName: newClass
        });
    }

    resetClick()
    {
        rideItOut = true;

        while(currentWeek < lastWeek)
        {
            pushNextDataPoint();
        }

        updateMessage();

    }

    render() {

        return (
            <div id="game" ref="game">
                { 
                    this.state.showResults ? 

                    <div id="timeTheMarketResults" ref="timeTheMarketResults" className="card">
                        <div className={this.state.didBeatTheMarket ? 'card-header text-white bg-success' : 'card-header text-white bg-danger'}>{this.state.beatTheMarketMessage}</div>
                        <div className="card-body">                        
                            <ul>
                            <li>
                                You just played the market from 
                                <strong> {this.state.startDate} </strong> through 
                                <strong> {this.state.endDate} </strong>
                            </li>
                            <li>Your investment grew to <strong> ${this.state.myValue.formatMoney(0)} </strong>
                                while the buy &amp; hold strategy netted <strong> ${this.state.vfinxValue.formatMoney(0)}</strong>.
                            </li>
                            <li>
                                You 
                                {
                                    this.state.didBeatTheMarket ?
                                    <span> BEAT </span> :
                                    <span> LOST to </span>
                                }
                                the market by
                                <strong> ${Math.abs(this.state.vfinxValue - this.state.myValue).formatMoney(0)}</strong>.
                            </li>
                            </ul>
                            <div className="text-center m-2">
                                <button className="btn btn-primary" onClick={this.buySellClick}>Play Again</button>
                            </div>
                        </div>
                    </div>
                    : null 
                }
                <div id="timeTheMarketChart">
                    Chart loading...
                </div>
                <button id="buySellButton" onClick={this.buySellClick} className={this.state.buySellButtonClassName}>{this.state.buttonText}</button>
                <div id="controlButtons" className="btn-group">
                    <button onClick={this.goSlower} className="btn btn-secondary btn-sm">Slower</button>
                    <button onClick={this.goFaster} className="btn btn-secondary btn-sm">Faster</button>
                    <button id="resetButton" onClick={this.resetClick} className="btn btn-secondary btn-sm">Skip to end</button>
                </div>
                <div id="scoreBoard">
                    <div className="card" id="yourInvestmentScore">
                        <div className="card-header">Your Investment</div>
                        <div className="card-body">${this.state.myValue.formatMoney(0)}</div>
                    </div>
                    <div className="card" id="buyAndHoldScore">
                        <div className="card-header">Buy & Hold</div>
                        <div className="card-body">${this.state.vfinxValue.formatMoney(0)}</div>
                    </div>
                </div>

            </div>
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



 