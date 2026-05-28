/**
 * Transaction Dashboard Module V2
 * 
 * Handles data fetching, chart rendering, and DOM updates for the transaction dashboard
 * Organized with clean separation of concerns using IIFE pattern
 * 
 * @module TransactionDashboard
 * @version 2.0
 */

const TransactionDashboard = (() => {
  'use strict';

  // ============================================================================
  // Utility Functions
  // ============================================================================

  /**
   * Formats a currency amount as Philippine Peso
   * 
   * @param {number} amount - The amount to format
   * @returns {string} - Formatted amount with ₱ symbol
   */
  function formatAmount(amount) {
    if (!amount) return '₱0.00';
    return '₱' + parseFloat(amount).toLocaleString('en-US', {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    });
  }

  /**
   * Formats a date string from YYYY-MM-DD to MM-DD-YYYY
   * 
   * @param {string} dateString - Date in YYYY-MM-DD format
   * @returns {string} - Formatted date in MM-DD-YYYY format
   */
  function formatDate(dateString) {
    if (!dateString) return '';
    const dateParts = dateString.split('-');
    return dateParts[1] + '-' + dateParts[2] + '-' + dateParts[0];
  }

  /**
   * Gets the current year
   * 
   * @returns {number} - Current year
   */
  function getCurrentYear() {
    return new Date().getFullYear();
  }

  /**
   * Creates a custom HTML tooltip for transaction amount data
   * 
   * @param {Object} data - Transaction data object
   * @returns {string} - HTML string for tooltip
   */
  function createCustomTooltip(data) {
    if (!data) {
      return '<div>No data available</div>';
    }

    const dateNow = data.date ?? '';
    const monthNow = data.month ?? '';
    const currentYear = getCurrentYear();

    let formedMonth = '';
    if (monthNow) {
      formedMonth = monthNow + ' ' + currentYear;
    }

    const formattedDate = formatDate(dateNow);

    return '<div style="padding:10px;">' +
      '<strong>' + formedMonth + '</strong><br>' +
      '<strong>' + formattedDate + '</strong><br><br>' +
      'Total Txn Amount: ₱' + data.total_txn_amount + '<br><br>' +
      'Pcab Fee: ₱' + data.pcab_fee + '<br>' +
      'LRF: ₱' + data.lrf + '<br>' +
      'Doc Stamp: ₱' + data.ds_tax + '<br>' +
      'NGSI Fee: ' + formatAmount(data.ngsi_convenience_fee) + '<br><br>' +
      '</div>';
  }

  /**
   * Creates a custom HTML tooltip for transaction count data
   * 
   * @param {Object} data - Transaction count data object
   * @returns {string} - HTML string for tooltip
   */
  function createCustomTooltipCount(data) {
    if (!data) {
      return '<div>No data available</div>';
    }

    const dateNow = data.date ?? '';
    const monthNow = data.month ?? '';
    const currentYear = getCurrentYear();

    let formedMonth = '';
    if (monthNow) {
      formedMonth = monthNow + ' ' + currentYear;
    }

    const formattedDate = formatDate(dateNow);

    return '<div style="padding:15px;">' +
      '<strong>' + formedMonth + '</strong><br>' +
      '<strong>' + formattedDate + '</strong><br><br>' +
      'Total Count: ' + data.total_count + '<br><br>' +
      'Success: ' + data.total_count_success + '<br>' +
      'Failed: ' + data.total_count_failed + '<br>' +
      'Created: ' + data.total_count_created + '<br><br>' +
      '</div>';
  }

  // ============================================================================
  // API Service
  // ============================================================================

  /**
   * Fetches dashboard report data from the server
   * 
   * @returns {Promise<Object>} - Report data object containing transaction info
   * @throws {Error} - If fetch fails
   */
  async function fetchDashboardData() {
    const baseUrl = document.querySelector('html').getAttribute('data-base-url') || 
                    (typeof BASE_URL !== 'undefined' ? BASE_URL : '/');
    const url = baseUrl + 'TransactionReport/dasboardReportData';

    try {
      const response = await fetch(url);
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      return await response.json();
    } catch (error) {
      console.error('Error fetching dashboard data:', error);
      throw error;
    }
  }

  // ============================================================================
  // DOM Update Functions
  // ============================================================================

  /**
   * Updates the summary cards with transaction totals
   * 
   * @param {Object} responseData - Response data from API
   */
  function updateSummaryCards(responseData) {
    const totalTxnAmount = responseData.alltransaction.total_txn_amount != null 
      ? responseData.alltransaction.total_txn_amount 
      : 0;
    const totalTxnAmountToday = responseData.today_transaction.total_txn_amount_today != null 
      ? responseData.today_transaction.total_txn_amount_today 
      : 0;
    const totalTxnAmountYesterday = responseData.yesterday_transaction.total_txn_amount_yesterday != null 
      ? responseData.yesterday_transaction.total_txn_amount_yesterday 
      : 0;

    const totalCount = responseData.alltransaction.total_count_success;
    const totalCountToday = responseData.today_transaction.total_count_today;
    const totalCountYesterday = responseData.yesterday_transaction.total_count_transaction;

    // Update amount cards
    document.getElementById('total-txn-amount').textContent = '₱' + totalTxnAmount;
    document.getElementById('total_txn_amount_today').textContent = '₱' + totalTxnAmountToday;
    document.getElementById('total_txn_amount_yesterday').textContent = '₱' + totalTxnAmountYesterday;

    // Update count cards
    document.getElementById('totalCount').textContent = totalCount;
    document.getElementById('totalCount_today').textContent = totalCountToday;
    document.getElementById('totalCount_yesterday').textContent = totalCountYesterday;
  }

  /**
   * Calculates and updates weekly total amount display
   * 
   * @param {Object} responseData - Response data from API
   */
  function updateWeeklyTotalAmount(responseData) {
    const daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    let weeklyTotalTxnAmount = 0;

    daysOfWeek.forEach(day => {
      if (responseData.all_transaction_this_week[day]) {
        weeklyTotalTxnAmount += parseFloat(
          (responseData.all_transaction_this_week[day].total_txn_amount ?? '0').replace(/,/g, '')
        );
      }
    });

    document.getElementById('weeklyTotalTxnAmount').textContent = '₱' + weeklyTotalTxnAmount.toLocaleString();
  }

  /**
   * Calculates and updates weekly total count display
   * 
   * @param {Object} responseData - Response data from API
   */
  function updateWeeklyTotalCount(responseData) {
    const daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    let weeklyTotalCount = 0;

    daysOfWeek.forEach(day => {
      if (responseData.all_transaction_this_week[day]) {
        weeklyTotalCount += parseFloat(
          (responseData.all_transaction_this_week[day].total_count_success ?? '0')
        );
      }
    });

    document.getElementById('weeklyTotalCount').textContent = weeklyTotalCount.toLocaleString();
  }

  // ============================================================================
  // Chart Configuration
  // ============================================================================

  /**
   * Gets the bar chart options configuration
   * 
   * @returns {Object} - Chart options for Google Charts
   */
  function getBarChartOptions() {
    return {
      backgroundColor: 'transparent',
      colors: ['#00507a', '#f08078'],
      fontName: 'Open Sans',
      chartArea: {
        left: 50,
        top: 10,
        width: '100%',
        height: '70%'
      },
      bar: {
        groupWidth: '70%'
      },
      hAxis: {
        textStyle: {
          fontSize: 11
        }
      },
      vAxis: {
        minValue: 0,
        baselineColor: '#6ad4cd',
        gridlines: {
          color: '#6ad4cd',
          count: 4
        },
        textStyle: {
          fontSize: 11
        }
      },
      legend: {
        position: 'bottom',
        textStyle: {
          fontSize: 12
        }
      },
      animation: {
        duration: 1200,
        easing: 'out'
      },
      tooltip: {
        isHtml: true
      }
    };
  }

  /**
   * Gets line chart options configuration
   * 
   * @returns {Object} - Chart options for Google Charts
   */
  function getLineChartOptions() {
    return {
      backgroundColor: 'transparent',
      colors: ['#00507a', '#f08078'],
      fontName: 'Open Sans',
      chartArea: {
        left: 50,
        top: 10,
        width: '100%',
        height: '70%'
      },
      hAxis: {
        textStyle: {
          fontSize: 11
        }
      },
      vAxis: {
        minValue: 0,
        baselineColor: '#6ad4cd',
        gridlines: {
          color: '#6ad4cd',
          count: 4
        },
        textStyle: {
          fontSize: 11
        }
      },
      legend: {
        position: 'bottom',
        textStyle: {
          fontSize: 12
        }
      },
      animation: {
        duration: 1200,
        easing: 'out'
      },
      lineWidth: 2,
      pointSize: 5,
      tooltip: {
        isHtml: true
      }
    };
  }

  // ============================================================================
  // Chart Data Processing
  // ============================================================================

  /**
   * Builds data array for daily transaction amount chart
   * 
   * @param {Object} responseData - Response data from API
   * @returns {Array} - Data array for Google Charts
   */
  function buildDailyAmountChartData(responseData) {
    const daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    const dailyDataArray = [
      ['Day', 'Success', {
        role: 'tooltip',
        'p': { 'html': true }
      }]
    ];

    daysOfWeek.forEach(day => {
      dailyDataArray.push([
        day.slice(0, 3),
        parseFloat(
          (responseData.all_transaction_this_week[day]?.total_txn_amount ?? '0').replace(/,/g, '')
        ),
        createCustomTooltip(responseData.all_transaction_this_week[day])
      ]);
    });

    return dailyDataArray;
  }

  /**
   * Builds data array for monthly transaction amount chart
   * 
   * @param {Object} responseData - Response data from API
   * @returns {Array} - Data array for Google Charts
   */
  function buildMonthlyAmountChartData(responseData) {
    const monthOfYear = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    const monthlyDataArray = [
      ['Day', 'Success', {
        role: 'tooltip',
        'p': { 'html': true }
      }]
    ];

    monthOfYear.forEach(month => {
      monthlyDataArray.push([
        month.slice(0, 3),
        parseFloat(
          (responseData.monthly_transaction[month]?.total_txn_amount ?? '0').replace(/,/g, '')
        ),
        createCustomTooltip(responseData.monthly_transaction[month])
      ]);
    });

    return monthlyDataArray;
  }

  /**
   * Builds data array for daily transaction count chart
   * 
   * @param {Object} responseData - Response data from API
   * @returns {Array} - Data array for Google Charts
   */
  function buildDailyCountChartData(responseData) {
    const daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    const dailyDataArrayCount = [
      ['Day', 'Success', {
        role: 'tooltip',
        'p': { 'html': true }
      }]
    ];

    daysOfWeek.forEach(day => {
      dailyDataArrayCount.push([
        day.slice(0, 3),
        responseData.all_transaction_this_week[day]?.total_count_success ?? '0',
        createCustomTooltipCount(responseData.all_transaction_this_week[day])
      ]);
    });

    return dailyDataArrayCount;
  }

  /**
   * Builds data array for monthly transaction count chart
   * 
   * @param {Object} responseData - Response data from API
   * @returns {Array} - Data array for Google Charts
   */
  function buildMonthlyCountChartData(responseData) {
    const monthOfYear = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    const monthlyDataArrayCount = [
      ['Day', 'Success', {
        role: 'tooltip',
        'p': { 'html': true }
      }]
    ];

    monthOfYear.forEach(month => {
      monthlyDataArrayCount.push([
        month.slice(0, 3),
        responseData.monthly_transaction[month]?.total_count_success ?? '0',
        createCustomTooltipCount(responseData.monthly_transaction[month])
      ]);
    });

    return monthlyDataArrayCount;
  }

  // ============================================================================
  // Chart Rendering
  // ============================================================================

  /**
   * Renders all charts on the dashboard
   * 
   * @param {Object} responseData - Response data from API
   */
  function renderCharts(responseData) {
    const barOptions = getBarChartOptions();
    const lineOptions = getLineChartOptions();

    // Prepare data
    const dailyAmountData = google.visualization.arrayToDataTable(buildDailyAmountChartData(responseData));
    const monthlyAmountData = google.visualization.arrayToDataTable(buildMonthlyAmountChartData(responseData));
    const dailyCountData = google.visualization.arrayToDataTable(buildDailyCountChartData(responseData));
    const monthlyCountData = google.visualization.arrayToDataTable(buildMonthlyCountChartData(responseData));

    // Render charts
    const dailyChart = new google.visualization.ColumnChart(document.getElementById('bar-chart-daily'));
    dailyChart.draw(dailyAmountData, barOptions);

    const monthlyChart = new google.visualization.ColumnChart(document.getElementById('line-chart-monthly'));
    monthlyChart.draw(monthlyAmountData, lineOptions);

    const dailyChartCount = new google.visualization.ColumnChart(document.getElementById('bar-chart-daily-count'));
    dailyChartCount.draw(dailyCountData, barOptions);

    const monthlyChartCount = new google.visualization.ColumnChart(document.getElementById('line-chart-monthly-count'));
    monthlyChartCount.draw(monthlyCountData, lineOptions);
  }

  // ============================================================================
  // Initialization
  // ============================================================================

  /**
   * Initializes the dashboard when DOM is ready
   */
  async function init() {
    try {
      // Load Google Charts library
      google.charts.load('current', { 'packages': ['corechart'] });
      google.charts.setOnLoadCallback(async () => {
        try {
          // Fetch data
          const responseData = await fetchDashboardData();

          // Update summary cards
          updateSummaryCards(responseData);

          // Update weekly totals
          updateWeeklyTotalAmount(responseData);
          updateWeeklyTotalCount(responseData);

          // Render charts
          renderCharts(responseData);
        } catch (error) {
          console.error('Error initializing dashboard:', error);
        }
      });
    } catch (error) {
      console.error('Error loading Google Charts:', error);
    }
  }

  // ============================================================================
  // Public API
  // ============================================================================

  return {
    init: init
  };
})();

// Initialize on document ready
document.addEventListener('DOMContentLoaded', TransactionDashboard.init);
