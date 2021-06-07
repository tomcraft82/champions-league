import React from 'react';

const Result = (props) => {
    return (
        <tr>
            <td>{props.game.team1_name}</td>
            <td>{props.game.team1_score} - {props.game.team2_score}</td>
            <td>{props.game.team2_name}</td>
        </tr>
    )
}

export default Result;