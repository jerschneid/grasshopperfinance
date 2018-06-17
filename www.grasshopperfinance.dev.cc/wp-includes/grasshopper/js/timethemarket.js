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
var vfinxPercentGain;
var myPercentGain;
var serverGameID = null;

function initChart() 
{
    serverGameID = null;

    chartData = [
      ['Week', 'Buy and Hold', 'Your Investment'],
    ];

    const numWeeks = vfinx.length;
    myCash = 0;

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

    vfinxPercentGain = (vfinxTotalValue / startingInvestment - 1);
    myPercentGain = (myTotalValue / startingInvestment - 1);

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

        this.apiUrlBase = "/wp-json/ghapi/v1";

        this.state = {
            buttonText: "Start!",
            holding: true,
            gameStarted: false,
            showResults: false,
            buySellButtonClassName: "btn btn-primary",
            myValue: startingInvestment,
            myPercentGain: 0,
            vfinxPercentGain: 0,
            vfinxValue: startingInvestment,
            trades: 0,
            didBeatTheMarket: null,
            beatTheMarketByDollars: null,
            beatTheMarketByPercent: null,
            recordResults: null
        }

        this.buySellClick = this.buySellClick.bind(this);
        this.skipToEndClick = this.skipToEndClick.bind(this);
        this.goFaster = this.goFaster.bind(this);
        this.goSlower = this.goSlower.bind(this);
        this.playAgain = this.playAgain.bind(this);
    }

    componentDidMount() 
    {
        this.getRecordBoardResults();
    }    

    formatDate(date)
    {
        var options = { year: 'numeric', month: 'long', day: 'numeric' };
        return new Date(date).toLocaleDateString("en-US", options);
    }    

    formatDateForMySql(date)
    {
        return dateString =
            date.getUTCFullYear() + "-" +
            ("0" + (date.getUTCMonth()+1)).slice(-2) + "-" +
            ("0" + date.getUTCDate()).slice(-2) + " " +
            ("0" + date.getUTCHours()).slice(-2) + ":" +
            ("0" + date.getUTCMinutes()).slice(-2) + ":" +
            ("0" + date.getUTCSeconds()).slice(-2);

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

        //postStartGameToServer is listed as the callback as setState is async
        this.setState({
            buttonText: "Sell!",
            buySellButtonClassName: "btn btn-danger",
            startDate: vfinx[firstWeek][0]
        }, this.postStartGameToServer);


        setTimeout(updateChart, timeIntervalInMilliSeconds);
    }

    postStartGameToServer()
    {
        var postUrl = this.apiUrlBase + "/time_the_market_start_game";

        console.log("Start Date: " + this.state.startDate);

        axios.post(postUrl, {
            market_start_date: vfinx[firstWeek][0],
            start_money: startingInvestment,

          })
          .then(function (response) {
            if(response.status == 200)
            {
                serverGameID = response.data;
            }
          })
          .catch(function (error) {
            console.error(error);
        });
    }

    postEndGameToServer()
    {
        if(serverGameID == null)
            return;

        var postUrl = this.apiUrlBase + "/time_the_market_end_game";

        console.log("Posting to " + postUrl);

        axios.post(postUrl, {
            id: serverGameID,
            num_trades: this.state.trades,
            did_beat_market: this.state.didBeatTheMarket,
            beat_market_by_dollars: this.state.beatTheMarketByDollars,
            beat_market_by_percent: this.state.beatTheMarketByPercent,
            market_end_date: this.state.endDate,
            my_end_money: this.state.myValue,
            market_end_money: this.state.vfinxValue,

          })
          .then(function (response) {
            //To do: update scoreboard?
            console.error(response);
          })
          .catch(function (error) {
            console.error(error);
          });
    }

    updateScore()
    {
            this.setState({
                myValue: myTotalValue,
                vfinxValue: vfinxTotalValue,
                myPercentGain: 100 * myPercentGain,
                vfinxPercentGain: 100 * vfinxPercentGain
            });
    }

    getRecordBoardResults()
    {
        var getUrl = this.apiUrlBase + "/get_time_the_market_record_board";

        console.log("getting: " + getUrl);

        axios.get(getUrl)
          .then(response =>  {
            if(response.status == 200)
            {
                console.log(response);

                this.setState({
                    recordResults: response.data
                });
            }
          })
          .catch(function (error) {
            console.error(error);
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
            startDate: vfinx[firstWeek][0],
            endDate: vfinx[lastWeek][0],
            beatTheMarketMessage: message,
            didBeatTheMarket: didBeatTheMarket,
            beatTheMarketByDollars: this.state.myValue - this.state.vfinxValue,
            beatTheMarketByPercent: Math.pow(this.state.myValue / this.state.vfinxValue, 1 / (spanWeeks / 52.0)) - 1,
            buttonText: "Play Again",
            buySellButtonClassName: "btn btn-primary",
            gameStarted: false
        }, this.postEndGameToServer);

        //Scroll to the end game scoreboard
        var elmnt = this.refs.game;
        elmnt.scrollIntoView();
    }

    buySellClick() 
    {
        if(!this.state.gameStarted)
        {
            this.playAgain();
            return;
        }

        this.state.holding = !this.state.holding;
//        this.state.trades = 3;

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

        var newTrades = this.state.trades + 1;

        this.setState({
            buttonText: newText,
            buySellButtonClassName: newClass,
            trades: newTrades
        });
    }

    skipToEndClick()
    {
        rideItOut = true;

        while(currentWeek < lastWeek)
        {
            pushNextDataPoint();
        }

        //The chart seems to draw itself again, but not sure how?!
    }

    playAgain()
    {
        initChart();

        this.setState({
            holding: true,
            gameStarted: true,
            showResults: false,
            myValue: startingInvestment,
            vfinxValue: startingInvestment,
            myPercentGain: 0,
            vfinxPercentGain: 0,
            trades: 0,
            didBeatTheMarket: null
        });

        //Scroll to the end game scoreboard
        var elmnt = this.refs.game;
        elmnt.scrollIntoView();        

        this.startTheGame();
    }

    render() {

        return (
            <div id="game_container">
                <div id="game" ref="game" className="card mt-3 mb-3 pb-2">
                    <div className="card-header">
                        Time The Market Game
                    </div>
                    <div className="card-body pt-1">
                    { 
                        this.state.showResults ? 

                        <div id="timeTheMarketResults" ref="timeTheMarketResults" className="card">
                            <div className={this.state.didBeatTheMarket ? 'card-header text-white bg-success' : 'card-header text-white bg-danger'}>{this.state.beatTheMarketMessage}</div>
                            <div className={this.state.didBeatTheMarket ? 'card-body bg-win' : 'card-body bg-lose'}>                        
                                <ul>
                                <li>
                                    You just played the market from 
                                    <strong> { this.formatDate(this.state.startDate) } </strong> through 
                                    <strong> { this.formatDate(this.state.endDate) } </strong>
                                </li>
                                <li>Your investment grew to <strong> ${this.state.myValue.formatMoney(0)} </strong>
                                    while the buy &amp; hold strategy netted <strong> ${this.state.vfinxValue.formatMoney(0)}</strong>
                                </li>
                                <li>
                                    You 
                                    {
                                        this.state.didBeatTheMarket ?
                                        <span> BEAT </span> :
                                        <span> LOST to </span>
                                    }
                                    the market by
                                    <strong> ${ Math.abs(this.state.beatTheMarketByDollars).formatMoney(0) }</strong>
                                </li>
                                <li>
                                    Annualized, the market grew
                                    <strong> {(100 * (Math.pow(this.state.vfinxValue / startingInvestment, 1 / (spanWeeks / 52.0)) - 1)).toFixed(1) }% </strong>
                                    per year while your investment grew
                                    <strong> {(100 * (Math.pow(this.state.myValue / startingInvestment, 1 / (spanWeeks / 52.0)) - 1)).toFixed(1) }% </strong>
                                    per year, so you 
                                    {
                                        this.state.didBeatTheMarket ?
                                        <span> beat </span> :
                                        <span> lost to </span>
                                    }
                                    the market by
                                    <strong> { (100 * Math.abs(this.state.beatTheMarketByPercent)).toPrecision(2) }% </strong>
                                    per year
                                </li>
                                </ul>
                                <div className="text-center m-2">
                                    <button className="btn btn-primary" onClick={this.playAgain}>Play Again</button>
                                </div>
                            </div>
                        </div>
                        : null 
                    }
                    </div>
                    <div id="timeTheMarketChart">
                        Chart loading...
                    </div>
                    <button id="buySellButton" onClick={this.buySellClick} className={this.state.buySellButtonClassName}>{this.state.buttonText}</button>
                    {
                        this.state.gameStarted ?
                        <div id="controlButtons" className="btn-group">
                            <button onClick={this.goSlower} className="btn btn-light btn-sm">Slower</button>
                            <button onClick={this.goFaster} className="btn btn-light btn-sm">Faster</button>
                            <button id="skipToEndButton" onClick={this.skipToEndClick} className="btn btn-light btn-sm">Skip to end</button>
                        </div>
                        : null
                    }
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

                {
                this.state.recordResults ? 
                <div id="recordBoard" className="card mb-5">
                    <div className="card-header">
                        How did everyone do?
                    </div>
                    <div className="card-body p-4">
                        <p className="mb-3">
                                This game has been played <strong>{ this.state.recordResults["num_plays"]}</strong> times
                                with the player beating the
                                market <strong>{ 100 * parseFloat(this.state.recordResults["percent_beats"]).toPrecision(3)}%</strong> of the time
                                and { parseFloat(this.state.recordResults["avg_beat_market_by_dollars"]) > 0 ? " beating the " : " losing to the " } 
                                market by <strong>${ Math.abs(this.state.recordResults["avg_beat_market_by_dollars"]).formatMoney(0) }</strong> on average 
                                (<strong>{ 100 * parseFloat(this.state.recordResults["avg_beat_market_by_percent"]).toPrecision(3) }%</strong> annually).
                        </p>
                        <ul>
                            <li>
                                Those who have beat the market have 
                                beat the market by an average of <strong>${ Math.abs(this.state.recordResults["avg_beat_market_by_dollars_for_winners"]).formatMoney(0) } </strong>
                                (<strong>{ 100 * parseFloat(this.state.recordResults["avg_beat_market_by_percent_for_winners"]).toPrecision(2)}%</strong>)
                                making an average of <strong>{ parseFloat(this.state.recordResults["avg_num_trades_for_winners"]).toPrecision(2) }</strong> trades.

                            </li>
                            <li>
                                Those who lost to the market have 
                                lost by an average of <strong>${ Math.abs(this.state.recordResults["avg_beat_market_by_dollars_for_losers"]).formatMoney(0) } </strong>
                                (<strong>{ 100 * parseFloat(this.state.recordResults["avg_beat_market_by_percent_for_losers"]).toPrecision(2)}%</strong>)
                                making an average of <strong>{ parseFloat(this.state.recordResults["avg_num_trades_for_losers"]).toPrecision(2) }</strong> trades.

                            </li>
                        </ul>

                    </div>

                </div>
                :null
                }
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



 