import React from 'react';

import Result from './Result';

const Results = (props) => {
    let rowsHtml = '';

    if (props.games !== undefined) {
        rowsHtml = props.games.map(row => {
            return (
                <Result key={row.team_name} game={row} />
            )
        })
    }

    return (
        <div>
            <h3>Match Results</h3>
            <p>{props.week} Week Match Results</p>
            <table>
                <tbody>{rowsHtml}</tbody>
            </table>
        </div>
    )
}

export default Results;