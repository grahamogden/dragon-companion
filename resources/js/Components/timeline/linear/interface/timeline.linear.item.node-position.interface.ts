export enum NodePositionEnum {
    only = "only",
    start = "start",
    end = "end",
    both = "both",
}

export default interface TimelineLinearItemNodePositionInterface {
    truncateLine: NodePositionEnum;
}
