import React from 'react';

const TableRow = (props) => {
    return (
        <tr>
            <td>{props.data.team_name}</td>
            <td>{props.data.points}</td>
            <td>{props.week}</td>
            <td>{props.data.wins}</td>
            <td>{props.data.draws}</td>
            <td>{props.data.losses}</td>
            <td>{props.data.goal_difference}</td>
        </tr>
    )
}

export default TableRow;