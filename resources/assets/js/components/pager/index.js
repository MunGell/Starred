import React from 'react'

import Glyph from 'elemental/lib/components/Glyph'

export default React.createClass({

    getDefaultProps: function () {
        return {
            //onClickNext: null,
            //onClickPrev: null
        }
    },

    _renderButtons: function () {
        let buttons = [];
            if (this.props.disabled !== 'prev') {
                buttons.push(<button className="component-pager__button" onClick={this.props.onClickPrev}><Glyph icon="chevron-left"/> Previous</button>);
            }
            if (this.props.disabled !== 'next') {
                buttons.push(<button className="component-pager__button" onClick={this.props.onClickNext}>Next <Glyph icon="chevron-right"/></button>);
            }
        return buttons;
    },

    render: function () {
        return (
            <div className="component-pager">
                {this._renderButtons()}
            </div>
        )
    }
});
