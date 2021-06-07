import React from 'react';

const Prediction = (props) => {
    return (
        <tr>
            <td>{props.team}</td>
            <td>%{props.prediction}</td>
        </tr>
    )
}

export default Prediction;