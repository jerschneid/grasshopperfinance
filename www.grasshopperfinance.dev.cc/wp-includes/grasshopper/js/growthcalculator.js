//Not sure why these don't work, but we don't seem to need them...
//import React from 'react';
//import ReactDOM from 'react-dom';

var calculator;
var formData = [];

//This method starts everything and is called at the very bottom of the file
function Init()
{
    formData["age"] = 30;
    formData["retirementAge"] = 70;
    formData["startingInvestment"] = 1000;
    formData["monthlyInvestment"] = 250;   
    formData["annualCostOfLiving"] = 48000;
    formData["rateOfReturnSelect"] = "random";    
    formData["adjustForInflation"] = true;
    formData["startingYear"] = 1950;

    ReactDOM.render(<GrowthCalculator ref={(calculator) => {window.calculator = calculator}} />, document.getElementById("root"));
}


var chart = null;
var options = null;
var chartData = null;
var myCash = 0;
var myShares = 0;
var currentAge = 0;
var myTotalValue;
var vfinxTotalValue;
var vfinxPercentGain;
var myPercentGain;
var maxAge = 80;
var myTotalContributions = 0;

var usingMarket = false;
var rateOfReturn = 0.0;
var age;
var retirementAge;
var annualCostOfLiving;
var rateOfInflation = 0.02;
var investmentAtRetirement = 0;
var investmentAtMaxAge = 0;

var firstMarketMonth = 0;
var currentMarketMonth = 0;
var lastMarketMonth = 0;
var monthsPerDataPoint = 1;

function initChart() 
{

    chartData = new google.visualization.DataTable();

    chartData.addColumn('number', 'Age');
    chartData.addColumn('number', 'Your Contributions');
    chartData.addColumn('number', 'Your Total Investment');    
    chartData.addColumn({type:'string', role:'annotation'});
    chartData.addColumn({type:'string', role:'annotationText'});      

    myTotalContributions = 0;
    myCash = parseFloat(formData["startingInvestment"]);
    age = parseInt(formData["age"]);
    retirementAge = parseInt(formData["retirementAge"]);
    annualCostOfLiving = parseFloat(formData["annualCostOfLiving"]);
    currentAge = age;


    const numMonths = sp500.length;
    var spanMonths = (maxAge - age) * 12;


    //Pick a random starting between 0 and the last week minus the span
    firstMarketMonth = Math.floor(Math.random() * (numMonths - spanMonths));

    //Jump to the correct year
    if(formData["rateOfReturnSelect"] == "startingYear")
    {
        var firstYear = parseInt(sp500[0][0].substr(0,4))
        var startingMonth = (formData["startingYear"] - firstYear) * 12;

        if(startingMonth >= 0 && startingMonth < numMonths - spanMonths)
        {
            firstMarketMonth = startingMonth;
        }
        else if(startingMonth < 0)
        {
            firstMarketMonth = 0;
        }
        else
        {
            firstMarketMonth = numMonths - spanMonths - 1;
        }
    }

    currentMarketMonth = firstMarketMonth;
    lastMarketMonth = firstMarketMonth + spanMonths;


    if(formData["rateOfReturnSelect"] == "random" || formData["rateOfReturnSelect"] == "recent" || formData["rateOfReturnSelect"] == "startingYear")
    {
        usingMarket = true;
        myShares = myCash / sp500[currentMarketMonth][1];
    }
    else
    {
        usingMarket = false;
        rateOfReturn = parseFloat(formData["rateOfReturnSelect"]) / 100;
    }


    options = {
        'chartArea': {left: 85, top: 5, width: '82%', height: '90%'},
        'legend': {'position': 'none'},
        hAxis: {title: 'Age',  titleTextStyle: {color: '#333'}, minValue: formData["age"], maxValue: maxAge},
        vAxis: {title: 'Investment Portfolio Value', minValue: -1000, maxValue: 10000, format: 'short'},
        seriesType: 'area',
        series: {2: {type: 'line'}}
    };

    chart = new google.visualization.ComboChart(document.getElementById('calculator-chart'));
    chart.draw(chartData, options);

    console.log("Finished initChart()");
}

function pushNextDataPoint()
{
    if (currentAge < retirementAge)
    {
        var currentContribution = parseFloat(formData["monthlyInvestment"]) * monthsPerDataPoint;
        myTotalContributions += currentContribution;
        myCash += currentContribution;
        myShares += currentContribution / sp500[currentMarketMonth][1];
    }
    else
    {
        var currentWithdrawal = annualCostOfLiving * monthsPerDataPoint / 12.0;
        myTotalContributions -= currentWithdrawal;
        myShares -= currentWithdrawal / sp500[currentMarketMonth][1];
        myCash -= currentWithdrawal;
    }

    if(usingMarket)
    {
        myCash = sp500[currentMarketMonth][1] * myShares;
    }
    else if(myCash > 0)
    {
        myCash = myCash * (1 + rateOfReturn * monthsPerDataPoint / 12.0);
    }

    if(formData["adjustForInflation"])    
    {
        myCash = myCash * (1 - rateOfInflation * monthsPerDataPoint / 12.0);
        myShares = myShares * (1 - rateOfInflation * monthsPerDataPoint / 12.0);
    }

    if(currentAge <= retirementAge)
    {
        investmentAtRetirement = myCash;
    }

    if(currentAge <= maxAge)
    {
        investmentAtMaxAge = myCash;        
    }

    chartData.addRow([
        currentAge,
        myTotalContributions,
        myCash,
        null,
        null
    ]);    

    currentAge +=  monthsPerDataPoint / 12.0;
    currentMarketMonth += 1 * monthsPerDataPoint;
}

function updateChart()
{
    while(currentAge <= maxAge)
    {
        pushNextDataPoint();
    }

    //Put into a view so we can hide the SMA if box is unchecked
    var view = new google.visualization.DataView(chartData);
    chart.draw(view, options);

    calculator.updateInvestmentValues();
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

function formatDate(date)
{
    var options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(date).toLocaleDateString("en-US", options);
}  

class GrowthCalculator extends React.Component
{
    constructor(){
        super();

        this.state = {
            buttonText: "Start!",
            netWorthAtRetirement: 0,
            netWorthAtMaxAge: 0,
            retirementAge: formData["retirementAge"],
            usingMarket: usingMarket,
            marketSpan: null,
            isChecked: formData["adjustForInflation"],
            showStartingYear: false
        }

        this.calculateClick = this.calculateClick.bind(this);
        this.handleFormChange = this.handleFormChange.bind(this);
        this.handleRateOfReturnChange = this.handleRateOfReturnChange.bind(this);
    }

    componentDidMount() 
    {
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(initChart);
    }    

    calculateClick(event)
    {
        event.preventDefault();

        this.setState({ retirementAge: formData["retirementAge"]});


        // //For each year from the beginning to the end
        // var startMonth = 0;

        // while(startMonth < )



        initChart();
        updateChart();
    }

    handleFormChange(event)
    {
        if(event.target.type == "checkbox")
        {
            formData[event.target.name] = event.target.checked;
        
            //Checkboxes need to be told to uncheck if they have the check property?!
            this.setState({ isChecked: formData["adjustForInflation"]});
        }
        else
        {
            formData[event.target.name] = event.target.value;
        }

        return true;
    }

    handleRateOfReturnChange(event)
    {
        console.log("handleRateOfReturnChange")

        this.handleFormChange(event);

        var showStartingYear = false;

        if(formData["rateOfReturnSelect"] == "startingYear")
        {
            showStartingYear = true;
        }

        this.setState({ showStartingYear: showStartingYear});

        return true;
    }

    updateInvestmentValues()
    {
        //Not entirely sure why this needs to happen, but without it the market span is printing as a day earlier...
        var startDate = new Date(sp500[firstMarketMonth][0]);
        startDate.setDate(startDate.getDate() + 1);

        var marketSpan = formatDate(startDate) + " through " + formatDate(sp500[lastMarketMonth][0]);

        this.setState({
            netWorthAtRetirement: investmentAtRetirement,
            netWorthAtMaxAge: investmentAtMaxAge,
            usingMarket: usingMarket,
            marketSpan: marketSpan
        });        
    }

    render() {

        return (
            <div id="calculator">
                <hr />

                <form id="calculator-form" className="needs-validation">
                  <div className="form-row">
                    <div className="col-md-4 mb-3">
                      <label htmlFor="age">Your Age</label>
                      <input onChange={this.handleFormChange} name="age" type="text" className="form-control" id="age" placeholder={formData["age"]} />
                    </div>
                    <div className="col-md-4 mb-3">
                      <label htmlFor="startingInvestment">Starting Investment</label>
                      <div className="input-group">
                        <div className="input-group-prepend">
                          <span className="input-group-text" id="inputGroupPrepend">$</span>
                        </div>
                        <input onChange={this.handleFormChange} name="startingInvestment" type="text" className="form-control" placeholder={formData["startingInvestment"]}  />
                      </div>
                    </div>
                    <div className="col-md-4 mb-3">
                      <label htmlFor="monthlyInvestment">Monthly Investment</label>
                      <div className="input-group">
                        <div className="input-group-prepend">
                          <span className="input-group-text" id="inputGroupPrepend">$</span>
                        </div>
                          <input onChange={this.handleFormChange} name="monthlyInvestment" type="text" className="form-control" placeholder={formData["monthlyInvestment"]}  />
                        </div>
                    </div>
                  </div>
                  <div className="form-row">
                    <div className="col-md-7 mb-3">
                      <label htmlFor="rateOfReturnSelect">Rate of Return</label>
                      <select onChange={this.handleRateOfReturnChange} className="form-control" name="rateOfReturnSelect">
                          <option value="random">Random period of S&P 500 returns</option>
                          <option value="startingYear">Choose starting year of S&P 500 returns</option>
                          <option value="0">0%</option>
                          <option value="1">1%</option>
                          <option value="2">2%</option>
                          <option value="3">3%</option>
                          <option value="4">4%</option>
                          <option value="6">5%</option>
                          <option value="6">6%</option>
                          <option value="7">7%</option>
                          <option value="8">8%</option>
                          <option value="9">9%</option>
                          <option value="10">10%</option>
                          <option value="11">11%</option>
                          <option value="12">12%</option>
                      </select>
                    </div>
                    { 
                        this.state.showStartingYear ?                    
                        <div className="col-md-2 mb-3">
                            <label htmlFor="startingYear">Starting Year</label>
                            <input onChange={this.handleFormChange} name="startingYear" type="text" className="form-control" id="startingYear" placeholder={formData["startingYear"]} />
                        </div>                    
                        : null
                    }
                    <div className="col-md-2 mb-3 ml-4 pt-4">
                      <input onChange={this.handleFormChange} className="form-check-input" type="checkbox" checked={formData["adjustForInflation"]} name="adjustForInflation" />
                      <label className="form-check-label" htmlFor="adjustForInflation">
                        Adjust for Inflation
                      </label>
                    </div>

                  </div>
                  <div className="form-row">
                    <div className="col-md-4 mb-3">
                      <label htmlFor="retirementAge">Retirement Age</label>
                      <input onChange={this.handleFormChange} type="text" className="form-control" name="retirementAge" placeholder={formData["retirementAge"]} />
                    </div>
                    <div className="col-md-4 mb-3">
                      <label htmlFor="annualCostOfLiving">Annual Cost of Living</label>
                      <div className="input-group">
                        <div className="input-group-prepend">
                          <span className="input-group-text" id="inputGroupPrepend">$</span>
                        </div>
                        <input onChange={this.handleFormChange} type="text" className="form-control" name="annualCostOfLiving" placeholder={formData["annualCostOfLiving"]}  />
                      </div>
                    </div>
                     <div className="col-md-4 mb-3">
                        <button id="calculate" className="btn btn-primary btn-lg" onClick={this.calculateClick}>Calculate!</button>
                     </div>
                  </div>

                </form>
                <hr />

                <div id="investmentValues">
                    <div className="card" id="investmentAtRetirement">
                        <div className="card-header">Investment at Retirement</div>
                        <div className="card-body">${this.state.netWorthAtRetirement.formatMoney(0)}</div>
                    </div>
                    <div className="card" id="investmentAtMaxAge">
                        <div className="card-header">Investment at {maxAge}</div>
                        <div className="card-body">${this.state.netWorthAtMaxAge.formatMoney(0)}</div>
                    </div>
                </div>

                {
                    usingMarket ?
                    <div id="market-span">
                        <strong>Investment growth if you had invested from {this.state.marketSpan}</strong>
                    </div>
                    : null
                }

                <div id="calculator-chart">Chart Loading...</div>


                <hr />

                <h3>How does this work?</h3>
                <ul>
                    <li>The <span className="red">red</span> line above represents your total investment value over time.</li>
                    <li>The <span className="blue">blue</span> line above represents your actual cash total contribution and withdrawals.</li>
                    <li>If the red line ever goes below zero, you went bankrupt.</li>
                    <li>The chart is calculated by beginning with your starting investment, then every year until retirement adds your monthly investment (times 12) and
                        adjusts your investment for growth (either fixed percentage or based on gain of the market).
                    </li>
                    <li>
                        At and above the age of retirement, your monthly investment is not added and instead your annual cost of living is withdrawn.
                    </li>
                    <li>
                        When the "adjust for inflation" box is checked, your investment value is diminished by 2% per year as an approximation of inflation.
                        When this box is checked, you can imagine the future dollars can be spent at today's prices.
                    </li>
                    <li>
                        When using the actual S&P 500 returns, your is modeled by investing all of your current and future contributions in an S&P 500 index fund
                        with dividends reinvested. 
                    </li>
                </ul>
            </div>

        )
    }
}


//Keep this at the bottom of the file
Init();



 