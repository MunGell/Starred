import $ from 'jquery'
import _ from 'lodash'
import React from 'react'

export default React.createClass({

    getDefaultProps: function () {
        return {
            config: {},
            root: ''
        }
    },

    render: function () {
        return (
            <nav>
                <ul className="component-paginator component-paginator--simple pagination">
                    {( this.props.config.currentPage !== 1 ?
                        <li className="component-paginator__item component-paginator__item--prev">
                            <a href={'/#'+ this.props.root +'?page=' + (this.props.config.currentPage - 1)}  aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        : <li></li>
                    )}
                    {( this.props.config.to === this.props.config.perPage ?
                        <li className="component-paginator__item component-paginator__item--next">
                            <a href={'/#'+ this.props.root +'?page=' + (this.props.config.currentPage + 1)} aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                        : <li></li>
                    )}
                </ul>
            </nav>
        )
    }
});