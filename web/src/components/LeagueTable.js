import React from 'react';

import TableRow from './TableRow';

const LeagueTable = (props) => {
    let rowsHtml = '';

    if (props.tableData !== undefined) {
        rowsHtml = props.tableData.map(row => {
            return (
                <TableRow key={row.team_name} data={row} week={props.week} />
            )
        })
    }

    return (
        <div>
            <h3>League Table</h3>
                <table>
                <tbody>
                    <tr>
                        <th>Teams</th>
                        <th>PTS</th>
                        <th>P</th>
                        <th>W</th>
                        <th>D</th>
                        <th>L</th>
                        <th>GD</th>
                    </tr>
                    {rowsHtml}
                </tbody>
                </table>
        </div>
    )
}

export default LeagueTable