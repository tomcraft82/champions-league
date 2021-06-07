import React from 'react';
import Prediction from './Prediction';

const Predictions = (props) => {
    let rowsHtml = '';

    if (props.tableData !== undefined) {
        rowsHtml = props.tableData.map(row => {
            return (
                <Prediction key={row.team_name} team={row.team_name} prediction={row.prediction} />
            )
        })
    }

    return (
        <div>
            <p>{props.week} Week Predictions of Championship</p>
            {rowsHtml}
        </div>
    )
}

export default Predictions;