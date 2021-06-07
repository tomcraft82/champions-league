import React, { Component } from 'react';
import axios from 'axios';

import LeagueTable from './LeagueTable';
import Results from './Results';
import Predictions from './Predictions';

class League extends Component {
    state = {
        loading: false,
        response: [],
        currentWeek: 1
    };

    loadTable = (week) => {
        this.setState({ loading: true});

        axios.get(`${process.env.REACT_APP_HOST_API}/api/v1/league?week=${week}`)
            .then(tableResponse => {
                this.setState({
                    loading: false,
                    response: tableResponse.data,
                });
            })
            .catch(err => {
                this.setState({ loading: false });
                console.log(err);
            });
    }

    componentDidMount() {
        this.loadTable(this.state.currentWeek);
    }

    restartLeagueHandler() {
        this.setState({ currentWeek: 1})

        axios.post(`${process.env.REACT_APP_HOST_API}/api/v1/league`)
            .then(res => {
                this.playWeekHandler(this.state.currentWeek);
                this.loadTable(this.state.currentWeek);
            })
            .catch(err => {
                console.log(err);
            });
    }

    playAllHandler() {
        this.setState({ currentWeek: 3})

        axios.post(`${process.env.REACT_APP_HOST_API}/api/v1/play`)
            .then(res => {
                this.loadTable(this.state.currentWeek);
            })
            .catch(err => {
                console.log(err);
            });
    }

    playWeekHandler(week) {
        if (week > 3) {
            week = 3;
        }

        axios.post(`${process.env.REACT_APP_HOST_API}/api/v1/play?week=${week}`)
            .then(tableResponse => {
                this.setState({ currentWeek: week})
                this.loadTable(week);
            })
            .catch(err => {
                console.log(err);
            });
    }

    render() {
        let tableHtml = '';
        let resultsHtml = '';
        let predictionsHtml = '';

        if (this.state.loading) {
            tableHtml = 'loading';
        } else {
            tableHtml = <LeagueTable tableData={this.state.response.table} week={this.state.currentWeek} className='LeagueColumn' />;
            resultsHtml = <Results games={this.state.response.results} week={this.state.currentWeek} className='LeagueColumn' />;
            predictionsHtml = <Predictions tableData={this.state.response.table} week={this.state.currentWeek} />;
        }

        return (
            <div>
                <button onClick={() => this.restartLeagueHandler()}>Restart League</button>
                <button onClick={() => this.playAllHandler()}>Play All</button>
                <button onClick={() => this.playWeekHandler(this.state.currentWeek + 1)}>Next Week</button>
                {tableHtml}
                {resultsHtml}
                {predictionsHtml}
            </div>
        )
    }
}
    
export default League